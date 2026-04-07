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
        Schema::create('photo_evidences', function (Blueprint $table) {
            $table->id('photo_id');
            $table->foreignId('order_id')->constrained('orders', 'order_id');
            $table->string('file_path');
            $table->dateTime('upload_date');
            $table->enum('type', ['Loaded', 'Delivered']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_evidences');
    }
};
