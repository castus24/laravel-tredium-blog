<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserEmailUpdatelRequest;
use App\Models\EmailChange;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserEmailUpdateController extends Controller
{
    /**
     * @OA\Put(
     *     path="/User/Email/Update",
     *     operationId="PutUserEmailUpdate",
     *     tags={"User"},
     *     summary="Изменение адреса электронной почты пользователя",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserEmailUpdatelRequest"),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK. Адрес электронной почты пользователя изменен",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Адрес электронной почты успешно обновлен!",
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
     *                 example="The code field is required.",
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     type="object",
     *                     example={
     *                         "The code field is required.",
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
     * @param UserEmailUpdatelRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(UserEmailUpdatelRequest $request): JsonResponse|AnonymousResourceCollection
    {
        $user = User::query()->find(
            auth()->user()->getAuthIdentifier()
        );

        $model = EmailChange::query();
        $emailChange = $model->where('user_id', $user->getKey())->first();

        if ($emailChange) {
            if ($emailChange->getAttributeValue('code') !== $request->validated('code')) {
                return response()->json([
                    'message' => trans('user.code')
                ], ResponseAlias::HTTP_UNAUTHORIZED);
            }

            if (User::query()->where('email', $emailChange->getAttributeValue('email'))->first()) {
                return response()->json([
                    'message' => trans('user.unique')
                ], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
        else {
            return response()->json([
                'message' => trans('user.code')
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $user->update([
            'email' => $emailChange->getAttributeValue('email'),
        ]);

        $emailChange->delete();

        return response()->json([
            'message' => trans('user.update')
        ]);
    }
}
