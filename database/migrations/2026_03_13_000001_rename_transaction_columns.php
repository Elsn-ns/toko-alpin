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
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'payment_amount')) {
                $table->renameColumn('payment_amount', 'amount_paid');
            }
            if (Schema::hasColumn('transactions', 'change')) {
                $table->renameColumn('change', 'change_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'amount_paid')) {
                $table->renameColumn('amount_paid', 'payment_amount');
            }
            if (Schema::hasColumn('transactions', 'change_amount')) {
                $table->renameColumn('change_amount', 'change');
            }
        });
    }
};
