<?php

namespace App\Http\Controllers\Api\User\Contact;

use App\Http\Controllers\Controller;
use App\Models\UserContact;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserContactDeleteController extends Controller
{
    public function __invoke(UserContact $contact): JsonResponse
    {
        if ($contact->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'User not found.' //todo lang
            ], ResponseAlias::HTTP_FORBIDDEN);
        }

        $contact->delete();

        return response()->json([
            'message' => 'Contact deleted successfully' //todo lang
        ]);
    }
}
