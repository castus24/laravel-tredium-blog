<?php

namespace App\Http\Controllers\Api\User\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserContactAddRequest;
use App\Http\Resources\UserContactResource;
use App\Models\UserContact;
use Illuminate\Http\JsonResponse;

class UserContactAddController extends Controller
{
    public function __invoke(UserContactAddRequest $request): JsonResponse
    {
        $contact = UserContact::query()->create($request->validated());

        return response()->json([
            'message' => 'Contact created successfully', //todo lang
            'data' => new UserContactResource($contact)
        ]);
    }
}
