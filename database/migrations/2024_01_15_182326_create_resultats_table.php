<?php

use App\Models\Candidat;
use App\Models\PvBureau;
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
        Schema::create('resultats', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PvBureau::class)->nullable(false)->constrained("pv_bureaux")->onDelete('cascade');
            $table->foreignIdFor(Candidat::class)->nullable(false)->constrained()->onDelete('cascade');
            $table->integer('nombre_voix')->nullable(false);
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
        Schema::dropIfExists('resultats');
    }
};
