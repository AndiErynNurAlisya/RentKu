<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;
use App\Services\WhatsappChannel; // Import class channel WhatsApp Anda

class NotificationChannelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       Notification::extend('whatsapp', function ($app) {
            // Daftarkan 'whatsapp' driver dan kaitkan dengan class channel Anda
            return new WhatsappChannel();
        });
    }
}
