<?php
// Migration: 2024_01_01_000010_create_seller_earnings_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seller_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('order_item_id')->constrained()->onDelete('cascade');
            $table->decimal('gross_amount', 10, 2); // Total item price
            $table->decimal('commission_rate', 5, 2); // Platform commission %
            $table->decimal('commission_amount', 10, 2); // Commission deducted
            $table->decimal('net_amount', 10, 2); // Amount seller receives
            $table->enum('status', ['pending', 'available', 'withdrawn'])->default('pending');
            $table->timestamp('available_at')->nullable(); // When funds become available
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_earnings');
    }
};
