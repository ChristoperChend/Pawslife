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
        Schema::table('form_penyerahan_hewan', function (Blueprint $table) {
            $table->date('tanggal_steril')->nullable()->after('status_vaksin');
            $table->date('tanggal_vaksin')->nullable()->after('tanggal_steril');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_penyerahan_hewan', function (Blueprint $table) {
            $table->dropColumn('tanggal_steril');
            $table->dropColumn('tanggal_vaksin');
        });
    }
};
