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
            $table->integer('masa_percobaan')->nullable()->after('dokumen_legal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shelter', function (Blueprint $table) {
            if(Schema::hasColumn('shelter', 'masa_percobaan')){
                $table->dropColumn('masa_percobaan');
            }
        });
    }
};
