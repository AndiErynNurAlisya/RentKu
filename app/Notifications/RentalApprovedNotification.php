<?php

namespace App\Notifications;

// Hapus use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Services\WhatsappChannel; 

class RentalApprovedNotification extends Notification
{
    // HAPUS: use Queueable; 

    protected $rental;

    public function __construct($rental)
    {
        $this->rental = $rental;
        // HAPUS: $this->onQueue('whatsapp'); 
    }

    public function via(object $notifiable): array
    {
        // Tetap menggunakan custom channel
        return [WhatsappChannel::class]; 
    }
    
    // Metode ini dipanggil oleh WhatsappChannel untuk mendapatkan pesan
    public function toWhatsapp(object $notifiable): array 
    {
        $message = "*✅ KONFIRMASI BOOKING RENTKU* \n\n";
        $message .= "Halo {$notifiable->name},\n";
        $message .= "Permintaan sewa Anda untuk *{$this->rental->vehicle->brand} - {$this->rental->vehicle->plate_number}* telah *DISETUJUI* oleh Admin.\n\n";
        $message .= "Kode Sewa: {$this->rental->rental_code}\n";
        $message .= "Tanggal Sewa: " . date('d/m/Y', strtotime($this->rental->start_date)) . " s/d " . date('d/m/Y', strtotime($this->rental->end_date)) . "\n\n";
        $message .= "Mohon ambil kendaraan tepat waktu. Terima kasih.";

        return [
            'message' => $message,
        ];
    }
}