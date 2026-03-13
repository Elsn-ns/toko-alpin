<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $row) {
            $row->decimal('price_pack', 15, 2)->nullable()->after('price');
            $row->integer('units_per_pack')->default(1)->after('price_pack');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $row) {
            $row->dropColumn(['price_pack', 'units_per_pack']);
        });
    }
};
