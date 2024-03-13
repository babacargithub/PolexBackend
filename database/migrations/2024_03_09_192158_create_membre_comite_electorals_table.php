<?php

use App\Models\ComiteElectoral;
use App\Models\TypeMembre;
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
        Schema::create('membre_comite_electorals', function (Blueprint $table) {
            $table->id();
            $table->string('prenom')->nullable(false);
            $table->string('nom')->nullable(false);
            $table->string('telephone')->nullable(false);
            $table->char('sexe', 1)->nullable(); // Assuming sexe is either 'M' or 'F'
            $table->string('nin')->nullable(false)->unique(); // Assuming NIN is a string
            $table->string('commune')->nullable(false);
            $table->boolean('is_electeur')->default(false);
            $table->boolean('is_president')->default(false);
            $table->boolean('is_membre_bureau')->default(false);
            // type membre
            $table->foreignIdFor(TypeMembre::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(ComiteElectoral::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('membre_comite_electorals');
    }
};
