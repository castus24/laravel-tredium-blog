<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserNameUpdateRequest;
use App\Http\Resources\UserShowResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserNameUpdateController extends Controller
{
    /**
     * @OA\Put(
     *     security={{"Sanctum":{}}},
     *     path="/User/Name",
     *     operationId="PutUserName",
     *     tags={"User"},
     *     summary="Обновление имени пользователя",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserNameUpdateRequest"),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK. Имя обновлено",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Имя успешно обновлено!",
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 ref="#/components/schemas/UserShowResource",
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
     *                 example="Unauthenticated.",
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
     *                 example="The name field is required.",
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="object",
     *                     example={
     *                         "The name field is required.",
     *                     },
     *                 ),
     *             ),
     *         ),
     *     ),
     * )
     * @param UserNameUpdateRequest $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function __invoke(UserNameUpdateRequest $request): JsonResponse|AnonymousResourceCollection
    {
        $user = User::query()->find(
            auth()->user()->getAuthIdentifier()
        );

        $user->update(['name' => $request->validated('name')]);

        return response()->json(
            array_merge(
                ['message' => trans('user.name')],
                ['data' => new UserShowResource($user)]
            )
        );
    }
}
