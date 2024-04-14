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
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('user1_id')->constrained('users')->onDelete('cascade');
            //$table->foreignId('user2_id')->constrained('users')->onDelete('cascade');
            $table->Integer('user1_id');
            $table->Integer('user2_id');
            $table->Integer('reciver_id');
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
        Schema::dropIfExists('chat_rooms');
    }
};
