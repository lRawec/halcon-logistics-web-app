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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('customer_number')->constrained('customers', 'customer_number');
            $table->integer('invoice_number')->unique();
            $table->dateTime('order_date_time');
            $table->text('notes')->nullable();
            $table->enum('status', ['Ordered', 'InProcess', 'InRoute', 'Delivered'])->default('Ordered');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
