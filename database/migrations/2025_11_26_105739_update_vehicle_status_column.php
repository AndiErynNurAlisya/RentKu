<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Ubah menjadi minimal 15 karakter untuk amannya
            $table->string('status', 15)->change(); 
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Kembalikan ke panjang sebelumnya jika diperlukan
            $table->string('status', 5)->change(); 
        });
    }
};