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
            $table->renameColumn('nama', 'jenis_kambing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kambings', function (Blueprint $table) {
            $table->renameColumn('jenis_kambing', 'nama');
        });
    }
};
