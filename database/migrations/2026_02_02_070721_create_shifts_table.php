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
        Schema::dropIfExists('shifts');
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accountant_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('serial');
            $table->datetime('started_at')->default(now());
            $table->datetime('ended_at')->nullable();
            $table->decimal('opening_balance', 10, 2)->default(0);
            $table->decimal('closing_balance', 10, 2)->nullable();
            $table->string('opening_notes')->default('Everything is ok');
            $table->string('closing_notes')->nullable();
            $table->boolean('autoclose')->default(0);

            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_sessions');
    }
};
