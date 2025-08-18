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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->unsignedBigInteger('id_pabrik');
            $table->foreign('id_pabrik')->references('id')->on('pabriks')->onDelete('cascade');
            $table->unsignedBigInteger('id_pembeli');
            $table->foreign('id_pembeli')->references('id')->on('pembelis')->onDelete('cascade');
            $table->date('tanggal_transaksi')->useCurrent();
            $table->text('keterangan')->nullable();
            $table->date('tanggal_pengiriman')->nullable();
            $table->date('tanggal_pembayaran')->nullable();
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('pending');
            $table->enum('status_pengiriman', ['belum_dikirim', 'dikirim'])->default('belum_dikirim');
            $table->enum('status_pembayaran', ['belum_bayar', 'sudah_bayar'])->default('belum_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
