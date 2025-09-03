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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('value');
            $table->enum('currency', ['TRY', 'USD']);
            $table->date('due_date')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('owner_id');
            $table->enum('owner_type', ['contact', 'company']);
            $table->foreignId('deals_title_id')->constrained('deals_titles');
            $table->integer('position')->default(0);
            $table->string('email');
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
    
    
};
