<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_pesanans', function (Blueprint $table) {
            $table->decimal('harga_satuan', 12, 2)->after('subtotal')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('detail_pesanans', function (Blueprint $table) {
            $table->dropColumn('harga_satuan');
        });
    }
};
