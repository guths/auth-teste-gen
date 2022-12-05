<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Mailgun\Mailgun;

class MailService
{
    public function sendResetEmail($email, $token)
    {
        $user = User::query()->where('email', '=', $email)->select('name', 'email')->first();

        $link = env('APP_URL') . '/password/reset/?token=' . $token . '&email=' . urlencode($user?->email);

        try {
            Mail::to($email)->send(new \App\Mail\ResetPassword($link));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
