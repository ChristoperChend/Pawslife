<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
                'email' => 'pawslife67@gmail.com'
            ],
            'to' => [
                ['email' => $toEmail]
            ],
            'subject' => 'Kode OTP Pawslife - Reset Password',
            'htmlContent' => $this->generateOtpEmailTemplate($otp),
            'textContent' => "Kode OTP Anda: {$otp} (berlaku 5 menit)"
        ]);
        if ($response->successful()) {
            Log::debug("success",  [$response]);
            return response()->json(['message' => 'email sent']);
        } else {
            Log::debug("fail",  [$response]);
            return response()->json(['error' => 'fail email sent']);
        }
    }

    public function sendApprovalEmail($toEmail, $namaShelter) {
        $apiKey = env('SEND_EMAIL_API_KEY');

        $response = Http::withHeaders([
            'api-key' => $apiKey,
            'Content-Type' => 'application/json'
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => 'Pawslife',
                'email' => 'pawslife67@gmail.com'
            ],
            'to' => [
                ['email' => $toEmail]
            ],
            'subject' => 'Pendaftaran Shelter Disetujui - Pawslife',
            'htmlContent' => $this->generateApprovalTemplate($namaShelter),
            'textContent' => "Selamat, pendaftaran shelter Anda disetujui!"
        ]);

        if ($response->successful()) {
            Log::info("Approval email sent to {$toEmail}");
        } else {
            Log::error("Failed to send approval email", [$response->json()]);
        }
    }

    public function sendRejectionEmail($toEmail, $namaShelter) {
        $apiKey = env('SEND_EMAIL_API_KEY');

        $response = Http::withHeaders([
            'api-key' => $apiKey,
            'Content-Type' => 'application/json'
        ])->post('https://api.brevo.com/v3/smtp/email', [
            'sender' => [
                'name' => 'Pawslife',
                'email' => 'pawslife67@gmail.com'
            ],
            'to' => [
                ['email' => $toEmail]
            ],
            'subject' => 'Pendaftaran Shelter Ditolak - Pawslife',
            'htmlContent' => $this->generateRejectTemplate($namaShelter),
            'textContent' => "Mohon maaf, pendaftaran shelter Anda belum dapat disetujui."
        ]);

        if ($response->successful()) {
            Log::info("Rejection email sent to {$toEmail}");
        } else {
            Log::error("Failed to send rejection email", [$response->json()]);
        }
    }


    private function generateOtpEmailTemplate($otp) {
        $currentYear = date('Y');
        return "
        <html>
        <head>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f9f9f9; }
                .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; }
                .header { background: linear-gradient(135deg, #2c6ade, #71dff7); padding: 25px 30px; text-align: center; }
                .header h1 { color: white; margin: 0; font-size: 28px; font-weight: 700; }
                .header p { color: rgba(255,255,255,0.9); margin: 10px 0 0; font-size: 16px; }
                .content { padding: 30px; }
                .content h2 { color: #2C3E50; font-size: 24px; margin-bottom: 20px; }
                .otp-box { 
                    background: #F8F9FA; 
                    border: 2px dashed #4ECDC4; 
                    border-radius: 8px; 
                    padding: 20px; 
                    text-align: center; 
                    font-size: 32px; 
                    font-weight: bold; 
                    letter-spacing: 5px; 
                    color: #2C3E50; 
                    margin: 20px 0;
                    box-shadow: inset 0 0 10px rgba(0,0,0,0.05);
                }
                .note { 
                    background: #FFF8E1; 
                    border-left: 4px solid #FFD700; 
                    padding: 15px; 
                    margin: 20px 0; 
                    border-radius: 6px; 
                    font-size: 14px;
                }
                .footer { 
                    background: #2C3E50; 
                    color: white; 
                    text-align: center; 
                    padding: 20px; 
                    font-size: 12px;
                }
                .btn { 
                    display: inline-block; 
                    background: #4ECDC4; 
                    color: white; 
                    padding: 12px 24px; 
                    text-decoration: none; 
                    border-radius: 25px; 
                    font-weight: bold; 
                    margin: 15px 0; 
                    transition: all 0.3s ease;
                }
                .btn:hover { background: #45B7A9; transform: translateY(-2px); }
                @media (max-width: 600px) {
                    .container { margin: 10px; }
                    .header { padding: 20px; }
                    .content { padding: 20px; }
                    .otp-box { font-size: 28px; padding: 15px; }
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Pawslife</h1>
                    <p>Keamanan Akun Anda Adalah Prioritas Kami</p>
                </div>
                
                <div class='content'>
                    <h2>Reset Password</h2>
                    
                    <div class='otp-box'>
                        {$otp}
                    </div>
                    
                    <div class='note'>
                        ⏳ Kode ini berlaku selama <strong>5 menit</strong>. Jangan bagikan kode ini kepada siapa pun.
                    </div>
                    
                    <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
                </div>
                
                <div class='footer'>
                    &copy; {$currentYear} Pawslife. All rights reserved.
                </div>
            </div>
        </body>
        </html>
        ";
    }

    private function generateApprovalTemplate($namaShelter) {
        $currentYear = date('Y');

        return "
            <html>
            <head>
                <style>
                    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f9f9f9; }
                    .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; }
                    .header { background: linear-gradient(135deg, #2c6ade, #71dff7); padding: 25px 30px; text-align: center; }
                    .header h1 { color: white; margin: 0; font-size: 28px; font-weight: 700; }
                    .header p { color: rgba(255,255,255,0.9); margin: 10px 0 0; font-size: 16px; }
                    .content { padding: 30px; }
                    .content h2 { color: #28a745; font-size: 24px; margin-bottom: 20px; }
                    .info-box { 
                        background: #F0FFF4; 
                        border: 2px dashed #28a745; 
                        border-radius: 8px; 
                        padding: 20px; 
                        text-align: center; 
                        font-size: 18px; 
                        color: #2C3E50; 
                        margin: 20px 0;
                    }
                    .btn { 
                        display: inline-block; 
                        background: #28a745; 
                        color: white; 
                        padding: 12px 24px; 
                        text-decoration: none; 
                        border-radius: 25px; 
                        font-weight: bold; 
                        margin-top: 20px; 
                    }
                    .footer { 
                        background: #2C3E50; 
                        color: white; 
                        text-align: center; 
                        padding: 20px; 
                        font-size: 12px;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>Pawslife</h1>
                        <p>Shelter Anda Telah Disetujui</p>
                    </div>

                    <div class='content'>
                        <h2>Pendaftaran Disetujui</h2>

                        <p>Halo <strong>{$namaShelter}</strong>,</p>

                        <div class='info-box'>
                            Selamat! Pendaftaran shelter Anda telah <strong>disetujui</strong> oleh admin Pawslife.
                        </div>

                        <p>
                            Sekarang Anda sudah bisa masuk ke akun Anda dan mulai menggunakan semua fitur
                            yang tersedia di Pawslife.
                        </p>

                        <p style='margin-top: 25px;'>Terima kasih telah bergabung bersama Pawslife 🐾</p>
                    </div>

                    <div class='footer'>
                        &copy; {$currentYear} Pawslife. All rights reserved.
                    </div>
                </div>
            </body>
            </html>
        ";
    }


    private function generateRejectTemplate($namaShelter) {
        $currentYear = date('Y');

        return "
            <html>
            <head>
                <style>
                    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f9f9f9; }
                    .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden; }
                    .header { background: linear-gradient(135deg, #2c6ade, #71dff7); padding: 25px 30px; text-align: center; }
                    .header h1 { color: white; margin: 0; font-size: 28px; font-weight: 700; }
                    .header p { color: rgba(255,255,255,0.9); margin: 10px 0 0; font-size: 16px; }
                    .content { padding: 30px; }
                    .content h2 { color: #dc3545; font-size: 24px; margin-bottom: 20px; }
                    .info-box { 
                        background: #FFF5F5; 
                        border: 2px dashed #dc3545; 
                        border-radius: 8px; 
                        padding: 20px; 
                        text-align: center; 
                        font-size: 18px; 
                        color: #2C3E50; 
                        margin: 20px 0;
                    }
                    .btn { 
                        display: inline-block; 
                        background: #dc3545; 
                        color: white; 
                        padding: 12px 24px; 
                        text-decoration: none; 
                        border-radius: 25px; 
                        font-weight: bold; 
                        margin-top: 20px; 
                    }
                    .footer { 
                        background: #2C3E50; 
                        color: white; 
                        text-align: center; 
                        padding: 20px; 
                        font-size: 12px;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>Pawslife</h1>
                        <p>Informasi Pendaftaran Shelter</p>
                    </div>

                    <div class='content'>
                        <h2>Pendaftaran Belum Disetujui</h2>

                        <p>Halo <strong>{$namaShelter}</strong>,</p>

                        <div class='info-box'>
                            Mohon maaf, pendaftaran shelter Anda <strong>belum dapat disetujui</strong> saat ini.
                        </div>

                        <p>
                            Anda dapat melakukan pendaftaran kembali di Pawslife kapan saja.
                        </p>

                        <p style='margin-top: 25px;'>Terima kasih atas pengertian Anda.</p>
                    </div>

                    <div class='footer'>
                        &copy; {$currentYear} Pawslife. All rights reserved.
                    </div>
                </div>
            </body>
            </html>
        ";
    }
}
