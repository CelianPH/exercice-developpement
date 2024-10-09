<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncartTagTable extends Migration
{
    public function up()
    {
        Schema::create('encart_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('encart_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('encart_tag');
    }
}
