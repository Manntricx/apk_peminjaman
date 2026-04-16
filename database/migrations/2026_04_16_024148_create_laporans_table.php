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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petugas_id')->constrained('users');
            $table->string('judul');
            $table->string('tipe');
            $table->date('periode_mulai');
            $table->date('periode_selesai');
            $table->string('file_path')->nullable();
            $table->timestamp('dicetak_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
