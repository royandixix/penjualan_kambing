<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kambings', function (Blueprint $table) {
            if (Schema::hasColumn('kambings', 'nama')) {
                $table->dropColumn('nama');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kambings', function (Blueprint $table) {
            $table->string('nama'); // rollback
        });
    }
};
