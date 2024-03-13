<?php

use App\Models\Departement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('plenipots', function (Blueprint $table) {
            $table->id();
            $table->string('prenom');
            $table->string('nom');
            $table->bigInteger('telephone')->unique()->nullable();
            $table->string('nin')->unique()->nullable();
            $table->integer('num_electeur')->unique()->nullable();
            $table->foreignIdFor(Departement::class)->nullable(false);
            $table->string('arrondissement')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plenipots');
    }
};
