<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\MailService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::query()->where('email', '=', $request->get('email'))->first();

        if (!$user) {
            return response()->json([
                'message' => 'We can\'t find a user with that e-mail address.',
            ], 404);
        }

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $this->quickRandom(60),
            'created_at' => Carbon::now()
        ]);

        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();

        $mailService = new MailService();
        $success = $mailService->sendResetEmail($tokenData?->email, $tokenData?->token);

        return response()->json([
            'message' => 'We have e-mailed your password reset link!',
            'success' => $success,
        ]);
    }

    public function quickRandom($length = 16): string
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }
}
