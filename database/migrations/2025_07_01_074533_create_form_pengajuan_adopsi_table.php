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
        Schema::create('form_pengajuan_adopsi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('adopter_id')
                  ->constrained('adopter')
                  ->onDelete('cascade');
            
            $table->foreignId('hewan_id')
                  ->constrained('hewan')
                  ->onDelete('cascade');

            $table->foreignId('shelter_id')
                  ->constrained('shelter')
                  ->onDelete('cascade');
            
            $table->string('status_pengajuan');
            $table->string('alasan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_pengajuan_adopsi');
    }
};
