<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // HAPUS baris ini kalau sudah ada:
            // $table->string('qr_token', 100)->nullable()->unique();

            // BIARKAN yang ini jalan:
            if (!Schema::hasColumn('users', 'qr_svg')) {
                $table->longText('qr_svg')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'qr_svg')) {
                $table->dropColumn('qr_svg');
            }
        });
    }
};
