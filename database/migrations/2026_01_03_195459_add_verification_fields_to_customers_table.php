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
        Schema::table('customers', function (Blueprint $table) {
            $table->boolean('id_verified')->default(false)->after('id_proof_number');
            $table->timestamp('id_verified_at')->nullable()->after('id_verified');
            $table->text('verification_response')->nullable()->after('id_verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['id_verified', 'id_verified_at', 'verification_response']);
        });
    }
};
