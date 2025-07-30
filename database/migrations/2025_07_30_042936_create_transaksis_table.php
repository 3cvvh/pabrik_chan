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
            $table->unsignedBigInteger('id_pabrik');
            $table->foreign('id_pabrik')->references('id')->on('pabriks');
            $table->unsignedBigInteger('id_pembeli');
            $table->foreign('id_pembeli')->references('id')->on('pembelis');
            $table->unsignedBigInteger('id_produk');
            $table->foreign('id_produk')->references('id')->on('produks');
            $table->integer('jumlah');
            $table->integer('total_harga');
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('pending');
            $table->dateTime('tanggal_transaksi')->useCurrent();
            $table->dateTime('tanggal_pengiriman')->nullable();
            $table->enum('status_pengiriman', ['belum_dikirim', 'dikirim'])->default('belum_dikirim');
            $table->enum('status_pembayaran', ['belum_bayar', 'sudah_bayar'])->default('belum_bayar');
            $table->string('keterangan')->nullable();
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
