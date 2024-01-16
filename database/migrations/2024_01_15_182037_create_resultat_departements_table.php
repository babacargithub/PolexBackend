<?php

use App\Models\Centre;
use App\Models\Departement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up(): void
    {
        Schema::create('resultat_departements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Departement::class)->nullable(false)->constrained()->onDelete('cascade');
            $table->integer('inscrits')->nullable(false);
            $table->integer('votants')->nullable(false);
            $table->integer('suffrages_exprimes')->nullable(false);
            $table->integer('bulletins_nuls')->nullable(false);
            $table->boolean('certifie')->default(false);
            $table->string("photo_pv")->nullable();
            $table->integer("candidat_1")->nullable(false);
            $table->integer("candidat_2")->nullable(false);
            $table->integer("candidat_3")->nullable(false);
            $table->integer("candidat_4")->nullable(false);
            $table->integer("candidat_5")->nullable(false);
            $table->integer("candidat_6")->nullable(false);
            $table->integer("candidat_7")->nullable(false);
            $table->integer("candidat_8")->nullable(false);
            $table->integer("candidat_9")->nullable(false);
            $table->integer("candidat_10")->nullable(false);
            $table->integer("candidat_11")->nullable(false);
            $table->integer("candidat_12")->nullable(false);
            $table->integer("candidat_13")->nullable(false);
            $table->integer("candidat_14")->nullable(false);
            $table->integer("candidat_15")->nullable(false);
            $table->integer("candidat_16")->nullable(false);
            $table->integer("candidat_17")->nullable(false);
            $table->integer("candidat_18")->nullable(false);
            $table->integer("candidat_19")->nullable(false);
            $table->integer("candidat_20")->nullable(false);
            $table->integer("candidat_21")->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('resultat_departements');
    }
};
