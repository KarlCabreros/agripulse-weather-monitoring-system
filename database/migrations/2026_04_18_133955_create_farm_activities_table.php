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
    Schema::create('farm_activities', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->enum('type', ['Planting', 'Fertilizing', 'Irrigation', 'Harvesting', 'Pest Control', 'Other']);
        $table->text('description')->nullable();
        $table->date('activity_date');
        $table->enum('status', ['Pending', 'In Progress', 'Completed']);
        $table->string('location')->nullable();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('farm_activities');
    }
};
