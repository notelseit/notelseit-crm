<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nome');
            $table->string('stato')->default('nuovo'); // nuovo, in trattativa, vinto, perso
            $table->string('provenienza')->nullable();
            $table->date('data_creazione')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // responsabile
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('leads');
    }
}