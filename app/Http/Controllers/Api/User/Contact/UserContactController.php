<?php

namespace App\Http\Controllers\Api\User\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserContactAddRequest;
use App\Http\Requests\UserContactUpdateRequest;
use App\Http\Resources\UserContactResource;
use App\Models\UserContact;
use Illuminate\Http\JsonResponse;

class UserContactController extends Controller
{
    public function index(): JsonResponse
    {
        $contacts = UserContact::query()
            ->where('user_id', auth()->id())
            ->get();

        return response()->json([
            'data' => UserContactResource::collection($contacts)
        ]);
    }

    public function store(UserContactAddRequest $request): JsonResponse
    {
        $contact = UserContact::query()->create($request->validated());

        return response()->json([
            'message' => 'Contact created successfully',
            'data' => new UserContactResource($contact)
        ]);
    }

    public function show(UserContact $contact): JsonResponse
    {
        if ($contact->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json([
            'data' => new UserContactResource($contact)
        ]);
    }

    public function update(UserContactUpdateRequest $request, UserContact $contact): JsonResponse
    {
        if ($contact->user_id !== auth()->id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $contact->update($request->validated());

        return response()->json([
            'message' => 'Contact updated successfully',
            'data' => new UserContactResource($contact)
        ]);
    }

    public function destroy(UserContact $contact): JsonResponse
    {
        if ($contact->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        $contact->delete();

        return response()->json([
            'message' => 'Contact deleted successfully'
        ]);
    }
}
