<?php

namespace App\Http\Controllers\Api;

use App\Mail\ActivationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ActivationController extends Controller
{
    public function sendActivationEmail(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();
        $token = Str::random(60);  // Generate a unique token
        $user->activation_token = $token;
        $user->save();

        // Send email with token
        Mail::to($user->email)->send(new ActivationMail($user, $token));

        return response()->json([
            'message' => 'Activation email sent successfully!',
            'status' => 200
        ]);
    }
}
