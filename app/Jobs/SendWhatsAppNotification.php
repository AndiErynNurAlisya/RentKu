<?php

namespace App\Jobs;

use App\Models\Rental;
use App\Models\User; 
use App\Notifications\RentalApprovedNotification; 
use App\Notifications\RentalCompletedNotification; 
use App\Notifications\NewOrderCustomerNotification; 
use App\Notifications\NewOrderAdminNotification; 
use App\Notifications\ReminderPickupNotification;   // <-- TAMBAHKAN INI
use App\Notifications\ReminderReturnNotification;   // <-- TAMBAHKAN INI
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $notifiable;
    protected $rental;
    protected $type; 

    /**
     * Create a new job instance.
     *
     * @param \App\Models\Rental $rental
     * @param string $type Jenis notifikasi yang akan dikirim
     * @return void
     */
    public function __construct(object $notifiable, Rental $rental, string $type)
    {
        $this->notifiable = $notifiable;
        $this->rental = $rental;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // Karena tidak semua notifikasi menggunakan $this->notifiable (misal, reminder), 
            // kita tetap tentukan user, tapi kita prioritaskan $this->notifiable saat dispatch.
            // Asumsi notifikasi customer dan reminder menggunakan $this->rental->user.
            $user = $this->rental->user;
            
            switch ($this->type) {
                case 'customer_new_order':
                    // Gunakan $this->notifiable jika disubmit dari Controller (yaitu $rental->user)
                    $this->notifiable->notify(new NewOrderCustomerNotification($this->rental));
                    break;
                
                case 'customer_rental_approved':
                    $user->notify(new RentalApprovedNotification($this->rental));
                    break;
                
                case 'customer_rental_completed':
                    $user->notify(new RentalCompletedNotification($this->rental));
                    break;
                
                case 'admin_new_pending_order':
                    // SOLUSI FINAL: Gunakan $this->notifiable (AdminNotifiable) yang sudah dikirimkan
                    if ($this->notifiable) { 
                        $this->notifiable->notify(new NewOrderAdminNotification($this->rental));
                    } else {
                        Log::warning('Admin Notifiable object is missing for new order notification.');
                    }
                    break;

                case 'customer_reminder_pickup': 
                    $user->notify(new ReminderPickupNotification($this->rental));
                    break;

                case 'customer_reminder_return': 
                    $user->notify(new ReminderReturnNotification($this->rental));
                    break;
                    
                default:
                    Log::warning("Unknown notification type: {$this->type}");
                    break;
            }

            Log::info("WhatsApp Notification dispatched ({$this->type}) for Rental ID: {$this->rental->id}");

        } catch (\Exception $e) {
            Log::error("Failed to send WA notification ({$this->type}) for Rental ID: {$this->rental->id}. Error: {$e->getMessage()}");
            throw $e; 
        }
    }
}