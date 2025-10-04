<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('template_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_id');
            $table->tinyInteger('rating')->unsigned();
            $table->timestamp('created_at')->useCurrent();

            // Optionnel : ajouter une contrainte de clé étrangère si tu as une table templates
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('template_ratings');
    }
};
