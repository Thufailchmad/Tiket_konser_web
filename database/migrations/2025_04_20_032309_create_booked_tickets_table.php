<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booked_tickets', function (Blueprint $table) {
            $table->id();
            $table->string("code", 12);
            $table->unsignedBigInteger("ticketId");
            $table->unsignedBigInteger("userId");
            $table->timestamps();

            $table->foreign("ticketId")->references("id")->on("tickets");
            $table->foreign("userId")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booked_tickets');
    }
};
