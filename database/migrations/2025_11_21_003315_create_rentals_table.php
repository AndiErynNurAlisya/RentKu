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
    Schema::create('rentals', function (Blueprint $table) {
        $table->id();
        $table->string('rental_code')->unique(); // RNT-20250101-001
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
        $table->date('start_date');
        $table->date('end_date');
        $table->date('actual_return_date')->nullable();
        $table->integer('total_days');
        $table->decimal('price_per_day', 10, 2);
        $table->decimal('total_price', 10, 2);
        $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('pending');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
