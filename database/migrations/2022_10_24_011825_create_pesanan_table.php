<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('user_id');
            $table->foreignId('toko_id');
            $table->foreignId('alamat_id');
            $table->string('payment_transaction_id');
            $table->enum('transaction_status', ['pending', 'settlement', 'onroad', 'success']);
            $table->string('ekspedisi');
            $table->string('harga_ekspedisi');
            $table->string('destination');
            $table->string('origin');
            $table->string('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanan');
    }
};
