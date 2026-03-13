<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaction_details', function (Blueprint $row) {
            $row->string('unit_type')->default('unit')->after('quantity');
        });
    }

    public function down(): void
    {
        Schema::table('transaction_details', function (Blueprint $row) {
            $row->dropColumn('unit_type');
        });
    }
};
