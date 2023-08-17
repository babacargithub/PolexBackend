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
            $table->integer('num_electeur')->nullable(false);
            $table->string('prenom',190)->nullable(false);
            $table->string('nom',20)->nullable(false);
            $table->string('nin',15)->nullable(false);
            $table->string('region',20)->nullable(false);
            $table->string('bureau',3)->nullable();
            $table->integer('taille',)->nullable(false);
            $table->foreignIdFor(Parti::class)->nullable(false)->constrained();
            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::dropIfExists('parrainages');
    }
};
