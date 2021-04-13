<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('jumlah')->nullable();
            $table->float('harga');
            $table->string('ukuran');
            $table->text('deskripsi');
            $table->string('foto')->nullable(true);
            $table->foreignId('kategori_id');
            $table->foreignId('toko_id');
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
