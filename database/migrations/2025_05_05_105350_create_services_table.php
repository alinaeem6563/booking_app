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
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('provider_id')->constrained('users')->onDelete('cascade'); // Foreign key for provider
            $table->string('service_name'); // Name of the service
            $table->longText('service_description')->nullable(); // Description of the service
            $table->string('service_category'); // Category of the service
            $table->integer('service_duration'); // Duration in hours (1 to 24)
            $table->decimal('service_price', 8, 2); // Price of the service
            $table->string('service_location'); // Location of the service
            $table->string('service_image')->nullable(); // Main service image (optional)
            $table->boolean('service_status')->default(false); // Service status (active/inactive)
            $table->json('work_gallery')->nullable(); // Gallery of work (stored as JSON array)
            $table->json('service_offerings')->nullable(); // Service offerings (stored as JSON)
            $table->string('qualifications_certifications')->nullable(); // Qualifications and certifications
            $table->string('additional_services')->nullable(); // Additional services provided (optional)
            $table->timestamps(); // Created and updated timestamps
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
