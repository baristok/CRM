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
        Schema::create('tags_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')->constrained('notes_tags');
            $table->foreignId('note_id')->constrained('notes');
            $table->timestamps();

            $table->unique(['tag_id', 'note_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('tags_notes');
    }
};
