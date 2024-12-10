<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ForgotPasswordResetRequest;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @uses self::sendResetLink
 */
class ForgotPasswordController extends Controller
{
    use Notifiable;

    /**
     * The email for notify.
     *
     * @var string
     */
    public string $email;

    /**
     * The Hasher implementation.
     *
     * @var Hasher
     */
    protected HasherContract $hasher;

    /**
     * Create a new token repository instance.
     *
     * @param Hasher $hasher
     */
    public function __construct(HasherContract $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Send a password reset link to a user.
     *
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function sendResetLink(ForgotPasswordRequest $request): JsonResponse
    {
        $user = $this->getUser($request->input('email'));

        if (is_null($user)) {
            return response()->json([
                'message' => trans('passwords.user')
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        if ($this->recentlyCreatedToken($user)) {
            return response()->json([
                'message' => trans('passwords.throttled')
            ], ResponseAlias::HTTP_TOO_MANY_REQUESTS);
        }

        $token = $this->create($user);

        $this->sendPasswordResetNotification($token);

        return response()->json([
            'message' => trans('passwords.sent')
        ]);
    }

    /**
     * Get the user for the given credentials.
     *
     * @param string $email
     * @return Model|null
     */
    public function getUser(string $email): Model|null
    {
        return User::query()->where('email', $email)->first();
    }

    /**
     * Create a new token record.
     *
     * @param User $user
     * @return string
     */
    public function create(Model $user): string
    {
        $this->email = $user->getAttribute('email');

        $this->deleteExisting($this->email);

        $token = $this->createNewToken();

        DB::table($this->getTable())->insert($this->getPayload($this->email, $token));

        return $token;
    }

    /**
     * Delete all existing reset tokens from the database.
     *
     * @param string $email
     * @return int
     */
    protected function deleteExisting(string $email): int
    {
        return DB::table($this->getTable())->where('email', $email)->delete();
    }

    /**
     * Getting password reset tokens table.
     *
     * @return string
     */
    protected function getTable(): string
    {
        return config('auth.passwords.users.table');
    }

    /**
     * Create a new token for the user.
     *
     * @return string
     */
    public function createNewToken(): string
    {
        return hash_hmac('sha256', Str::random(40), null);
    }

    /**
     * Build the record payload for the table.
     *
     * @param string $email
     * @param string $token
     * @return array
     */
    protected function getPayload(string $email, string $token): array
    {
        return [
            'email' => $email,
            'token' => $this->hasher->make($token),
            'created_at' => new Carbon
        ];
    }

    /**
     * Determine if the given user recently created a password reset token.
     *
     * @param Model $user
     * @return bool
     */
    public function recentlyCreatedToken(Model $user): bool
    {
        $record = (array) DB::table($this->getTable())->where(
            'email', $user->getAttribute('email')
        )->first();

        return $record && $this->tokenRecentlyCreated($record['created_at']);
    }

    /**
     * Determine if the token was recently created.
     *
     * @param string $createdAt
     * @return bool
     */
    protected function tokenRecentlyCreated(string $createdAt): bool
    {
        $throttle = config('auth.passwords.users.throttle');

        if ($throttle <= 0) {
            return false;
        }

        return Carbon::parse($createdAt)->addSeconds($throttle)->isFuture();
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification(string $token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Reset the password for the given token.
     *
     * @param ForgotPasswordResetRequest $request
     * @return JsonResponse
     */
    public function reset(ForgotPasswordResetRequest $request): JsonResponse
    {
        $user = $this->validateReset($request);

        if (!$user instanceof Model) {
            return $user;
        }

        $this->update($user, $request->input('password'));

        $this->deleteExisting($user->getAttribute('email'));

        return response()->json([
            'message' => trans('passwords.reset')
        ]);
    }

    /**
     * Validate a password reset for the given credentials.
     *
     * @param ForgotPasswordResetRequest $request
     * @return JsonResponse|Model
     */
    protected function validateReset(ForgotPasswordResetRequest $request): Model|JsonResponse
    {
        $user = $this->getUser($request->input('email'));

        if (is_null($user)) {
            return response()->json([
                'message' => trans('passwords.user')
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        if (! $this->exists($user, $request->input('token'))) {
            return response()->json([
                'message' => trans('passwords.token')
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        return $user;
    }

    /**
     * Determine if a token record exists and is valid.
     *
     * @param Model $user
     * @param string $token
     * @return bool
     */
    public function exists(Model $user, string $token): bool
    {
        $record = (array) DB::table($this->getTable())->where(
            'email', $user->getAttribute('email')
        )->first();

        return $record
            && ! $this->tokenExpired($record['created_at'])
            && $this->hasher->check($token, $record['token']);
    }

    /**
     * Determine if the token has expired.
     *
     * @param string $createdAt
     * @return bool
     */
    protected function tokenExpired(string $createdAt): bool
    {
        return Carbon::parse($createdAt)->addMinutes(
            config('auth.passwords.users.expire')
        )->isPast();
    }

    /**
     * Update user password.
     *
     * @param Model $user
     * @param string $password
     * @return bool
     */
    protected function update(Model $user, string $password): bool
    {
        return $user->update([
            'password' => Hash::make($password)
        ]);
    }
}
