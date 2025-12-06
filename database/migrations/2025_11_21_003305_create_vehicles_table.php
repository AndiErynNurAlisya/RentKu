<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('vehicles', function (Blueprint $table) {
        $table->id();
        $table->string('brand'); // Honda, Yamaha, Toyota
        $table->string('type'); // Beat, Vario, Avanza
        $table->string('plate_number')->unique(); // DD 1234 AB
        $table->enum('category', ['motor', 'mobil']);
        $table->decimal('price_per_day', 10, 2); // Harga sewa per hari
        $table->enum('status', ['tersedia', 'disewa', 'maintenance'])->default('tersedia');
        $table->string('image')->nullable();
        $table->text('description')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
