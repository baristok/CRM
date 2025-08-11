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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id')->constrained('note_boards')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->integer('progress')->default(0); // 0-100 arası ilerleme durumu
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->nullable();
            $table->date('due_date')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained('users');
            // $table->json('tags')->nullable();
            $table->integer('position')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
    
};
