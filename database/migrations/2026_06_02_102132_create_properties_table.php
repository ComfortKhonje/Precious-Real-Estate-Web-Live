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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('location');
            $table->decimal('price', 15, 2);
            $table->string('currency')->default('MWK');
            $table->string('status')->default('For Sale'); // For Sale, For Rent
            $table->string('type'); // House, Plot, Commercial, etc.
            
            // Specifications
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->string('land_size')->nullable();
            $table->integer('parking_spaces')->nullable();
            
            // Media
            $table->string('featured_image');
            $table->json('gallery')->nullable();
            
            // Flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_available')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
