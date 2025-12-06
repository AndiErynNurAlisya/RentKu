<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class WhatsappChannel
{
    /**
     * Kirim notifikasi yang diberikan.
     * * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send(object $notifiable, Notification $notification): void
    {
        // 1. Dapatkan data pesan (DIHARAPKAN BERUPA ARRAY DENGAN KUNCI 'message')
        // Ini adalah langkah kritis yang sebelumnya menyebabkan error 'Cannot access offset...'
        $messageData = $notification->toWhatsapp($notifiable);
        $targetNumber = $notifiable->routeNotificationFor('whatsapp');

        // 2. Buat Payload untuk API WhatsApp
        $payload = [
            'target' => $targetNumber,
            'message' => $messageData['message'], // Aman diakses jika $messageData adalah array
            'delay' => 1,
        ];

        // 3. Lakukan Panggilan HTTP
        $response = Http::withHeaders([
            'Authorization' => env('WHATSAPP_API_KEY'), 
        ])->asForm()->post(env('WHATSAPP_API_URL'), $payload);

        // 4. Catat Kegagalan
        if ($response->failed()) {
            Log::error('Gagal mengirim WhatsApp.', [
                'response_body' => $response->body(),
                'status' => $response->status(),
                'target' => $targetNumber  
            ]);
        }
    }
}