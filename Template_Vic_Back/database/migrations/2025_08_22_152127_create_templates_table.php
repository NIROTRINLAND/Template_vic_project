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
            $table->id();
            $table->string('name')->nullable();           // Nom du template
            $table->string('slug')->unique()->nullable(); // URL friendly
            $table->string('folder');                     // Nom du dossier où le template est stocké
            $table->decimal('price', 10, 2)->default(0); // Prix du template
            $table->boolean('is_paid')->default(false);  // Si le template est payant
            $table->boolean('is_public')->default(true); // Si le template est visible publiquement
            $table->string('screenshot')->nullable();    // Chemin vers screenshot
            $table->string('preview_link')->nullable();  // Lien de prévisualisation
            $table->foreignId('creator_id')->nullable()->constrained('users')->onDelete('set null'); // Créateur
            $table->timestamps();
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
