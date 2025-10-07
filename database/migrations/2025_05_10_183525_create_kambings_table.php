<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kambings', function (Blueprint $table) {
            $table->id();
            $table->string('nama');                   // Nama kambing
            $table->string('jenis_kambing')->nullable(); // Jenis/ras kambing
            $table->integer('umur');                  // Umur dalam bulan atau tahun
            $table->float('berat');                   // Berat kambing
            $table->enum('jenis_kelamin', ['jantan', 'betina']);
            $table->decimal('harga', 12, 2);
            $table->integer('stok')->default(0);     // Jumlah stok tersedia
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kambings');
    }
};
