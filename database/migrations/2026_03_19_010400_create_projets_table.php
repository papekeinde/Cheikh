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
        Schema::create('projets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('titre');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('lien')->nullable();
            $table->string('github')->nullable();
            $table->json('tags');
            $table->integer('ordre')->default(0);
            $table->integer('complexite')->default(50);
            $table->string('type')->default('Web');
            $table->string('status')->default('pending');
            $table->integer('progress')->default(0);
            $table->text('admin_feedback')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};
