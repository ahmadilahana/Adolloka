<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableTransaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->id();
            $table->timestamp("tgl_transaksi");
            $table->foreignId('barang_id');
            $table->foreignId('toko_id');
            $table->text('keterangan')->nullable();
            $table->integer('jumlah');
            $table->double('total_harga');
            $table->foreignId('akun_id');
            $table->foreignId('alamat_id');
            $table->enum('status', ['pembayaran', 'sudah dibayar','packing', 'pengiriman','diterima']);
            $table->string('bukti_pembayaran')->nullable();
            $table->string('kode_resi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
