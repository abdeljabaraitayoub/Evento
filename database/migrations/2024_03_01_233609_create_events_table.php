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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_date');
            $table->string('location')->nullable();
            $table->integer('capacity')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->dateTime('deleted_at')->nullable();
            $table->boolean('auto_approve')->default(false);
            $table->foreignId('region_id')->constrained();
            $table->boolean('is_valid')->default(false);
            $table->float('price')->default('10.99');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
