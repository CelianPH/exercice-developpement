<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_encarts_table.php
    public function up()
    {
        Schema::create('encarts', function (Blueprint $table) {
            $table->id();
            $table->string('Référence');
            $table->string('image_bannière');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->json('tags'); 
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encarts');
    }
};
