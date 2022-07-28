<?php

namespace App\Http\Controllers\Api\System;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends BaseController
{

    public function update(Request $request) : JsonResponse
    {
        /** @var User $current_user */
        $current_user = auth()->user();
        $user         = User::findOrFail($current_user->id);

        if ($request->get('password') != '') {
            $user->password = Hash::make(trim($request->get('password')));
        }

        $user->save();

        return response()->json($user);
    }
}
