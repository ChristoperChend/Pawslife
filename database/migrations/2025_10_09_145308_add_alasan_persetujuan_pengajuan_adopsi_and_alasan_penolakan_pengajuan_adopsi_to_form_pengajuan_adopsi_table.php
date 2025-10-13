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
            $table->string('alasan_persetujuan_pengajuan_adopsi')->nullable()->after('alasan');
            $table->string('alasan_penolakan_pengajuan_adopsi')->nullable()->after('alasan_persetujuan_pengajuan_adopsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_pengajuan_adopsi', function (Blueprint $table) {
            if(Schema::hasColumn('form_pengajuan_adopsi', 'alasan_persetujuan_pengajuan_adopsi')){
                $table->dropColumn('alasan_persetujuan_pengajuan_adopsi');
            }

            if(Schema::hasColumn('form_pengajuan_adopsi', 'alasan_penolakan_pengajuan_adopsi')){
                $table->dropColumn('alasan_penolakan_pengajuan_adopsi');
            }
        });
    }
};
