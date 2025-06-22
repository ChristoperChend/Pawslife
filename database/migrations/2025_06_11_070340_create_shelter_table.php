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
        Schema::create('shelter', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengguna_id')
                  ->constrained('pengguna')
                  ->onDelete('cascade');

            $table->string('nama_shelter');
            $table->string('alamat_shelter');
            $table->string('deskripsi_shelter');
            $table->string('no_telepon_shelter');
            $table->string('dokumen_legal');
            $table->string('foto_shelter');
            $table->string('status');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelter');
    }
};
