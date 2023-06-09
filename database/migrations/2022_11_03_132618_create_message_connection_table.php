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
        Schema::create('message_connection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('receiver_id');
            $table->string('connection');
            $table->enum('status', [null, 'waiting', 'read']);
            $table->string('last_message')->nullable();
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
        Schema::dropIfExists('message_connection');
    }
};
