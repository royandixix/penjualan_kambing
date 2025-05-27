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
        Schema::table('pesanans', function (Blueprint $table) {
            if (!Schema::hasColumn('pesanans', 'metode_bayar')) {
                $table->string('metode_bayar')->after('total_harga');
            }

            if (!Schema::hasColumn('pesanans', 'bukti_bayar')) {
                $table->string('bukti_bayar')->nullable()->after('metode_bayar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanans', function (Blueprint $table) {
            if (Schema::hasColumn('pesanans', 'bukti_bayar')) {
                $table->dropColumn('bukti_bayar');
            }

            if (Schema::hasColumn('pesanans', 'metode_bayar')) {
                $table->dropColumn('metode_bayar');
            }
        });
    }
};
