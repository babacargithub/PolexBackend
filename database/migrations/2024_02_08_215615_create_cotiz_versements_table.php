<?php

use App\Models\Cotiz;
use App\Models\Membre;
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
    public function up()
    {
        Schema::create('cotiz_versements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Cotiz::class);
            $table->integer('montant')->nullable(false);
            $table->foreignIdFor(Membre::class);
            $table->string('reference');
            $table->string('paye_par');
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
        Schema::dropIfExists('cotiz_versements');
    }
};
