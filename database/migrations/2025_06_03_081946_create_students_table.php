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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nationality');
            $table->string('position')->nullable();
            $table->string('laterality');
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->string('medication')->nullable();
            $table->date('date_init');
            $table->date('date_end')->nullable();
            $table->date('date_of_birth');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
