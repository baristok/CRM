<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('leads_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads');
            $table->foreignId('tag_id')->constrained('tags_leads');
            $table->timestamps();

            // Aynı potansiyel müşteriye aynı etiketin birden fazla kez eklenmesini önlemek için
            $table->unique(['lead_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('leads_tags');
    }
};
