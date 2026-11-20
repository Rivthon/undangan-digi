<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guest_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->enum('attendance', ['hadir', 'tidak_hadir', 'masih_ragu']);
            $table->unsignedTinyInteger('guest_count')->default(1);
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_messages');
    }
};
