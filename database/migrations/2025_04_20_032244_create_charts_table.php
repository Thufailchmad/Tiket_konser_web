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
        Schema::create('charts', function (Blueprint $table) {
            $table->id();
            $table->integer("qty", 3)->autoIncrement(false);
            $table->unsignedBigInteger("userId");
            $table->unsignedBigInteger("ticketId");
            $table->timestamps();

            $table->foreign("userId")->references("id")->on("users");
            $table->foreign("ticketId")->references("id")->on("tickets");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charts');
    }
};
