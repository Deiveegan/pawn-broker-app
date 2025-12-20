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
        Schema::table('loans', function (Blueprint $table) {
            $table->string('interest_type')->default('Flat')->after('interest_rate');
            $table->integer('loan_period_months')->after('duration_days');
            $table->integer('grace_period_days')->default(0)->after('due_date');
            $table->decimal('penalty_rate', 5, 2)->default(0)->after('grace_period_days');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['interest_type', 'loan_period_months', 'grace_period_days', 'penalty_rate']);
        });
    }
};
