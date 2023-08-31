<?php

use App\Models\Parti;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('parrainages', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('num_electeur')->nullable(false);
            $table->string('prenom',190)->nullable(false);
            $table->string('nom',20)->nullable(false);
            $table->string('nin',15)->nullable(false);
            $table->string('region',30)->nullable(false);
            $table->string('bureau',3)->nullable();
            $table->string('discriminant')->nullable();
            $table->string('date_naiss')->nullable();
            $table->string('lieu_naiss')->nullable();
            $table->string('centre')->nullable();
            $table->string('annee_naiss')->nullable();
            $table->integer('taille',)->nullable();
            $table->foreignIdFor(Parti::class)->nullable(false)->constrained();
            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::dropIfExists('parrainages');
    }
};
