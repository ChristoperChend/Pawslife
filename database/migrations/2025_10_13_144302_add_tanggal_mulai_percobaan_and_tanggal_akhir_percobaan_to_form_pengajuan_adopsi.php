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
        Schema::table('form_pengajuan_adopsi', function (Blueprint $table) {
            $table->date('tanggal_mulai_percobaan')->nullable()->after('alasan_penolakan_pengajuan_adopsi');
            $table->date('tanggal_akhir_percobaan')->nullable()->after('tanggal_mulai_percobaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_pengajuan_adopsi', function (Blueprint $table) {
            $table->dropColumn('tanggal_mulai_percobaan');
            $table->dropColumn('tanggal_akhir_percobaan');
        });
    }
};
