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
        Schema::create('adopter', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pengguna_id')
                  ->constrained('pengguna')
                  ->onDelete('cascade');

            $table->string('nama_lengkap');
            $table->string('alamat');
            $table->integer('usia');
            $table->string('pekerjaan');
            $table->string('no_handphone');
            $table->string('no_whatsapp');
            $table->string('foto_adopter');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adopter');
    }
};
