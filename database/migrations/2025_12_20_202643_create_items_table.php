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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->string('category'); // Gold, Silver, Electronics, etc.
            $table->string('item_name');
            $table->text('description');
            $table->decimal('weight', 8, 3)->nullable(); // for jewelry
            $table->string('purity')->nullable(); // for jewelry (22K, 18K, etc.)
            $table->decimal('estimated_value', 10, 2);
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
