<?php

namespace App\Http\Controllers\Api\User\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserContactUpdateRequest;
use App\Http\Resources\UserContactResource;
use App\Models\UserContact;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserContactUpdateController extends Controller
{
    public function __invoke(UserContactUpdateRequest $request, UserContact $contact): JsonResponse
    {
        if ($contact->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'User not found.' //todo lang
            ], ResponseAlias::HTTP_FORBIDDEN);
        }

        $contact->update($request->validated());

        return response()->json([
            'message' => 'Contact updated successfully', //todo lang
            'data' => new UserContactResource($contact)
        ]);
    }
}
