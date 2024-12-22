<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserEmailEmailRequest;
use App\Models\EmailChange;
use App\Models\User;
use App\Notifications\VerifyEmailChangeNotification;
use Faker\Core\Number;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserEmailEmailController extends Controller
{
    /**
     * @var int
     */
    public int $throttle = 60;

    /**
     * @OA\Post(
     *     path="/User/Email/Email",
     *     operationId="PostUserEmailEmail",
     *     tags={"User"},
     *     summary="Отправка кода подтверждения для изменения адреса электронной почты пользователя",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserEmailEmailRequest"),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK. Письмо отправлено",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Код подтверждения успешно отправлен на ваш текущий адрес электронной почты.",
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="UNAUTHORIZED. Пользователь не аутентифицирован",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Эти учетные данные не соответствуют нашим записям.",
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="UNPROCESSABLE CONTENT. Валидация данных не пройдена",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The email field must be a valid email address. (and 1 more error)",
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     type="object",
     *                     example={
     *                         "The email field must be a valid email address.",
     *                         "The email field must not be greater than 255 characters.",
     *                     },
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="429",
     *         description="TOO MANY REQUESTS. Cлишком частые запросы",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Пожалуйста, подождите, прежде чем повторить попытку.",
     *             ),
     *         ),
     *     ),
     * )
     *
     * @param UserEmailEmailRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(UserEmailEmailRequest $request): JsonResponse|AnonymousResourceCollection
    {
        $user = User::query()->find(
            auth()->user()->getAuthIdentifier()
        );

        if (! Hash::check($request->validated('password'), $user->getAttribute('password'))) {
            return response()->json([
                'message' => trans('auth.failed')
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $model = EmailChange::query();
        $query = $model->where('user_id', $user->getKey())->first();

        if ($query) {
            if (Carbon::parse($query->getAttributeValue('sented_at'))->addSeconds($this->throttle)->isFuture()) {
                return response()->json([
                    'message' => trans('base.throttle')
                ], ResponseAlias::HTTP_TOO_MANY_REQUESTS);
            }

            if ($query->getAttributeValue('email') !== $request->validated('email')) {
                $query->update([
                    'user_id' => $user->getKey(),
                    'email' => $request->validated('email'),
                    'code' => app(Number::class)->randomNumber(6, true),
                ]);
            }
        }
        else {
            $query = $model->create([
                'user_id' => $user->getKey(),
                'email' => $request->validated('email'),
                'code' => app(Number::class)->randomNumber(6, true),
            ]);
        }

        Notification::route('mail', $user->getAttributeValue('email'))->notify(
            new VerifyEmailChangeNotification($query->getAttributeValue('code'))
        );

        $query->update([
            'sented_at' => $query->freshTimestamp(),
        ]);

        return response()->json([
            'message' => trans('user.email', ['email' => $user->getAttributeValue('email')])
        ]);
    }
}
