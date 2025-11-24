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
        Schema::table('shelter', function (Blueprint $table) {
            $table->string('nama_bank')->nullable()->after('no_telepon_shelter');
            $table->string('nomor_rekening')->nullable()->after('nama_bank');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shelter', function (Blueprint $table) {
            if(Schema::hasColumn('shelter', 'nama_bank')){
                $table->dropColumn('nama_bank');
            }

            if(Schema::hasColumn('shelter', 'nomor_rekening')){
                $table->dropColumn('nomor_rekening');
            }
        });
    }
};
