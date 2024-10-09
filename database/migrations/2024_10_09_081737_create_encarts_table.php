<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
       Schema::create('encarts', function (Blueprint $table) {
            $table->id(); // Champ id auto-incrémenté
            $table->string('Référence')->notNullable();
            $table->string('image_bannière')->notNullable();
            $table->date('date_debut')->notNullable();
            $table->date('date_fin')->notNullable();
            $table->text('tags')->nullable(); // Utilisation de TEXT pour les tags
            $table->timestamps();
        });

        // Ajouter la contrainte CHECK via une requête brute
        DB::statement('ALTER TABLE encarts ADD CONSTRAINT chk_dates CHECK (date_fin > date_debut)');
        
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encarts');
    }
};
