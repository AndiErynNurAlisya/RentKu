<?php

namespace App\Notifications;

use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewOrderAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $rental;

    public function __construct(Rental $rental)
    {
        $this->rental = $rental;
    }

    public function via($notifiable)
    {
        // Notifikasi Admin sangat krusial, sebaiknya menggunakan WA
        return ['whatsapp']; 
    }

    public function toWhatsapp($notifiable)
    {
        $message = "🚨 *PERHATIAN: PESANAN BARU MASUK!* 🚨\n\n";
        $message .= "Kode Booking: *{$this->rental->rental_code}*\n";
        $message .= "Customer: {$this->rental->user->name}\n";
        $message .= "Kendaraan: {$this->rental->vehicle->brand} {$this->rental->vehicle->type}\n";
        $message .= "Periode: {$this->rental->start_date->format('d/m')} - {$this->rental->end_date->format('d/m/Y')}\n\n";
        $message .= "Segera cek Dashboard Admin untuk persetujuan (status: Pending).";
        
        return [
            'message' => $message
        ];
    }
}