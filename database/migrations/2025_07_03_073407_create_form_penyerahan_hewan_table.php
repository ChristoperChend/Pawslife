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
        Schema::create('form_penyerahan_hewan', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('shelter_id')->nullable();

            $table->foreignId('adopter_id')
                  ->constrained('adopter')
                  ->onDelete('cascade');

            $table->string('nama_hewan');
            $table->string('ras');
            $table->integer('berat');
            $table->string('status_steril');
            $table->string('status_vaksin');
            $table->string('catatan_medis');
            $table->string('foto_hewan');
            $table->string('jenis_hewan');
            $table->string('alasan_penyerahan');
            $table->string('jenis_kelamin');
            $table->string('status_penyerahan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_penyerahan_hewan');
    }
};
