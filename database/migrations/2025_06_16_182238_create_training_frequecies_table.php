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
        Schema::create('training_frequecies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained()->cascadeOnDelete();
            $table->foreignId('categorystudent_id')->constrained('category_students')->onDelete('cascade');
            $table->string('presence')->default('ausente');
            $table->string('filled')->default('não');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_frequecies');
    }
};
