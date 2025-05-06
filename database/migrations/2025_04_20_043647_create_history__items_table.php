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
        Schema::create('history_items', function (Blueprint $table) {
            $table->id();
            $table->integer("qty", 3)->autoIncrement(false);
            $table->unsignedBigInteger("ticketId");
            $table->unsignedBigInteger("historyId");
            $table->timestamps();

            $table->foreign("ticketId")->references("id")->on("tickets");
            $table->foreign("historyId")->references("id")->on("histories");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history__items');
    }
};
