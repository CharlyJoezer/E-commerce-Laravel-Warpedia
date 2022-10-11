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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('username');
            $table->string('password');
            $table->enum('gender', ['Laki-Laki', 'Perempuan'])->nullable();
            $table->text('tanggal_lahir')->nullable();
            $table->string('telepon');
            $table->string('foto_profil')->nullable();
            $table->boolean('telepon_limit')->default(true);
            $table->boolean('username_limit')->default(true);
            $table->boolean('tanggal_lahir_limit')->default(true);
            $table->boolean('telepon_limit')->default(true);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
