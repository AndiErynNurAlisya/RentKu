<?php

namespace App\Notifications;

use App\Models\Rental;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * Notifikasi WhatsApp untuk Customer saat membuat pesanan rental baru
 * Dikirim setelah customer berhasil melakukan booking kendaraan
 * Status rental: PENDING (menunggu persetujuan admin)
 */
class NewOrderCustomerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Instance dari model Rental yang baru dibuat
     * 
     * @var Rental
     */
    protected $rental;

    /**
     * Constructor - Menerima data rental untuk dikirim dalam notifikasi
     * 
     * @param Rental $rental - Data rental yang baru dibuat
     */
    public function __construct(Rental $rental)
    {
        $this->rental = $rental;
    }

    /**
     * Menentukan channel notifikasi yang digunakan
     * Dalam hal ini menggunakan channel 'whatsapp'
     * 
     * @param mixed $notifiable - Target penerima notifikasi (Customer)
     * @return array - Array berisi channel yang digunakan
     */
    public function via($notifiable)
    {
        return ['whatsapp'];
    }

    /**
     * Membuat konten pesan WhatsApp yang akan dikirim ke customer
     * Berisi informasi konfirmasi booking dan detail rental
     * 
     * @param mixed $notifiable - Target penerima notifikasi (Customer)
     * @return array - Array berisi pesan WhatsApp
     */
    public function toWhatsapp($notifiable)
    {
        // Menyusun pesan konfirmasi booking untuk customer
        $message = "Halo {$this->rental->user->name},\n";
        $message .= "Pesanan Anda berhasil dibuat dan statusnya *PENDING*!\n\n";
        $message .= "Kode Booking: *{$this->rental->rental_code}*\n";
        $message .= "Kendaraan: {$this->rental->vehicle->brand} {$this->rental->vehicle->type}\n";
        $message .= "Total Biaya: Rp " . number_format($this->rental->total_price, 0, ',', '.') . "\n\n";
        $message .= "Admin kami akan segera memproses persetujuan. Kami akan memberitahu Anda setelah statusnya *ACTIVE*. Terima kasih!";
        
        // Return array dengan key 'message' untuk channel WhatsApp
        return [
            'message' => $message
        ];
    }
}