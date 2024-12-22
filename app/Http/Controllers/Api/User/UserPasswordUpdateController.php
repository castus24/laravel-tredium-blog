<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPasswordUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserPasswordUpdateController extends Controller
{
    /**
     * @OA\Put(
     *     path="/User/Password/Update",
     *     operationId="PutUserPasswordUpdate",
     *     tags={"User"},
     *     summary="Изменение пароля пользователя",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserPasswordUpdateRequest"),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK. Пароль пользователя изменен",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Пароль успешно обновлен!",
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
     *                 example="The password field is required.",
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     type="object",
     *                     example={
     *                         "The password field is required.",
     *                     },
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     *
     * @param UserPasswordUpdateRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(UserPasswordUpdateRequest $request): JsonResponse|AnonymousResourceCollection
    {
        $user = User::query()->find(
            auth()->user()->getAuthIdentifier()
        );

        if (! Hash::check($request->validated('password_current'), $user->getAttribute('password'))) {
            return response()->json([
                'message' => trans('auth.failed')
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $user->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        return response()->json([
            'message' => trans('user.password')
        ]);
    }
}
