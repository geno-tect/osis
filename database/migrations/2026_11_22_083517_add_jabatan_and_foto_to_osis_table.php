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
        Schema::table('osis', function (Blueprint $table) {
            $table->enum('jabatan', [
                'Ketua Umum',
                'Wakil Ketua',
                'Sekretaris',
                'Bendahara',
                'Anggota',
            ])->nullable()->after('id_osis');
            $table->string('foto')->nullable()->after('jabatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('osis', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'foto']);
        });
    }
};