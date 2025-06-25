<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class mailController extends Controller
{
    public function sendEmail($toEmail, $otp) {
        $apiKey = env('SEND_EMAIL_API_KEY');
        $response = Http::withHeaders([
            'api-key' => $apiKey,
            'Content-Type' => 'application/json'
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => 'Pawslife',
                'email' => 'christoper.chendra15@gmail.com'
            ],
            'to' => [
                ['email' => $toEmail]
            ],
            'subject' => 'Kode OTP Pawslife',
            'htmlContent' => 
                "<html>
                    <body>
                        <h2>Reset Password</h2>
                        <p>Kode OTP Anda adalah: <b>{{ $otp }}</b></p>
                        <p>Kode berlaku selama 5 menit.</p>
                    </body>
                </html>"
        ]);
        if ($response->successful()) {
            return response()->json(['message' => 'email sent']);
        } else {
            return response()->json(['error' => 'fail email sent']);
        }
    }
}
