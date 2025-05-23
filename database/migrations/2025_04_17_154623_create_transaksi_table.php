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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idanggota');
            $table->integer('jenistrans');
            $table->decimal('jumlah', 15, 2);
            $table->string('keterangan')->nullable();
            $table->integer('idgambar')->nullable();
            $table->integer('status')->default(1);
            $table->string('alasan')->nullable();
            $table->unsignedBigInteger('author')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
