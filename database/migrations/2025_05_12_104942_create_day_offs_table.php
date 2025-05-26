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
        Schema::create('provider_days_off', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained('users')->onDelete('cascade');

            // Type of day off: weekly (like Saturday) or specific date
            $table->enum('type', ['weekly', 'date']);

            // For type = 'weekly', store day name (e.g., 'Saturday')
            $table->string('day_name')->nullable();

            // For type = 'date', store exact date
            $table->date('off_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_offs');
    }
};
