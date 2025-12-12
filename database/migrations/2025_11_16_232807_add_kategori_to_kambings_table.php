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
        Schema::table('kambings', function (Blueprint $table) {
            if (!Schema::hasColumn('kambings', 'kategori')) {
                $table->enum('kategori', [
                    'Kambing Kacang',
                    'Kambing Peranakan Etawa'
                ])->default('Kambing Kacang')->after('jenis_kambing');
            }
        });
    }

    /**
     * Rexverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kambings', function (Blueprint $table) {
            if (Schema::hasColumn('kambings', 'kategori')) {
                $table->dropColumn('kategori');
            }
        });
    }
};
