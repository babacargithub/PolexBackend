<?php

use App\Models\Collecte;
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
        Schema::create('collecte_participants', function (Blueprint $table) {
            $table->foreignIdFor(Collecte::class);
            $table->integer('montant')->nullable(false);
            $table->string('prenom')->nullable(false);
            $table->string('nom')->nullable(false);
            $table->bigInteger('telephone')->nullable(false);
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
        Schema::dropIfExists('collecte_participants');
    }
};
