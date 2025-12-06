<?php

namespace App\Notifications;

use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage; // Jika Anda juga ingin mengirim email

// Asumsi: Anda telah menginstal dan mengkonfigurasi WhatsApp Channel 
// (Misalnya, melalui penyedia pihak ketiga yang diintegrasikan dengan Laravel Notifications)

class RentalCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $rental;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Rental $rental
     * @return void
     */
    public function __construct(Rental $rental)
    {
        $this->rental = $rental;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Tetapkan channel pengiriman utama ke WhatsApp
        return ['whatsapp'];
    }

    // ----------------------------------------------------
    // 🔥 METHOD UTAMA UNTUK PESAN WHATSAPP (Final Invoice)
    // ----------------------------------------------------

    /**
     * Get the WhatsApp representation of the notification.
     *
     * @param mixed $notifiable
     * @return string|array
     */
    public function toWhatsapp($notifiable)
    {
        // 1. Hitung ulang data biaya untuk memastikan akurasi
        // Data ini diambil dari model Rental yang sudah di-update di Admin\RentalController@complete
        $damageCost = $this->rental->damages->sum('damage_cost');
        $penaltyCost = $this->rental->penalty_cost ?? 0;
        
        // Harga sewa awal (Base Price) sebelum denda/kerusakan
        $originalBasePrice = $this->rental->total_days * $this->rental->price_per_day; 
        
        $message = "🎉 *Transaksi Selesai - RentKu* 🎉\n\n";
        $message .= "Kepada Yth. {$this->rental->user->name},\n";
        $message .= "Kode Booking: *{$this->rental->rental_code}*\n";
        $message .= "Kendaraan: {$this->rental->vehicle->brand} {$this->rental->vehicle->type}\n\n";
        
        $message .= "Kendaraan telah berhasil dikembalikan pada tanggal " . $this->rental->actual_return_date->format('d/m/Y H:i') . ".\n";
        $message .= "---------------------------------------\n";
        
        $message .= "🏷️ *RINGKASAN BIAYA*\n";
        $message .= "Sewa Dasar ({$this->rental->total_days} hari): Rp " . number_format($originalBasePrice, 0, ',', '.') . "\n";
        
        if ($damageCost > 0) {
            $message .= "⚠️ Biaya Kerusakan: + Rp " . number_format($damageCost, 0, ',', '.') . "\n";
        }
        
        if ($penaltyCost > 0) {
            $message .= "⏳ Denda Keterlambatan: + Rp " . number_format($penaltyCost, 0, ',', '.') . "\n";
        }
        
        $message .= "---------------------------------------\n";
        $message .= "💰 *TOTAL TAGIHAN AKHIR:* Rp " . number_format($this->rental->total_price, 0, ',', '.') . "\n\n";

        if ($damageCost > 0 || $penaltyCost > 0) {
             $message .= "ℹ️ *Catatan:* Biaya tambahan (denda/kerusakan) telah ditambahkan ke total akhir. Mohon cek detail transaksi Anda.\n\n";
        }
        
        $message .= "Terima kasih atas kepercayaan Anda. Kami nantikan pemesanan Anda selanjutnya!";

        return [
            'message' => $message
        ];
    }

    // ----------------------------------------------------
    // (Opsional) Method toMail, toDatabase, dll.
    // ----------------------------------------------------
    
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->subject('Invoice Final Rental Kendaraan Anda')
    //                 ->line('Terima kasih! Transaksi rental Anda telah selesai.')
    //                 // ... logic email ...
    //                 ->action('Lihat Detail Invoice', url('/customer/rentals/' . $this->rental->id));
    // }
}