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
        Schema::create('templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('folder');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_public')->default(true);
            $table->string('screenshot')->nullable();
            $table->string('preview_link')->nullable();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->timestamps(); // created_at et updated_at
            $table->longText('description')->nullable();
            $table->integer('download')->default(0);

            // clé étrangère
            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
