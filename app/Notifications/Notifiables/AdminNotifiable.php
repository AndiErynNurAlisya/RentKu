<?php

namespace App\Notifications\Notifiables;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;

class AdminNotifiable
{
    use Notifiable;

    public function routeNotificationForWhatsapp()
    {
        // Ganti env() dengan Config::get()
        return Config::get('whatsapp.admin_number'); 
    }
}