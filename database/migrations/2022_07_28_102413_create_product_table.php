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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->foreignId('user_id');
            $table->foreignId('toko_id');
            $table->foreignId('kategori_id');
            $table->text('deskripsi_produk');
            $table->string('harga_produk');
            $table->string('stok_produk');
            $table->string('minimal_pesan');
            $table->string('gambar_produk');
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
        Schema::dropIfExists('product');
    }
};
