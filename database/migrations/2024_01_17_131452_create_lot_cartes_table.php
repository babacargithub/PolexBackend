<?php

use App\Models\Membre;
use App\Models\TypeCarteMembre;
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
        Schema::create('lot_cartes', function (Blueprint $table) {
            $table->id();
            $table->integer("numero")->nullable(false)->unique();
            $table->integer("nombre")->nullable();

            $table->string("type_lot")->nullable();
            $table->foreignIdFor(Membre::class)->nullable()->constrained()->onDelete('set null');
            $table->foreignIdFor(TypeCarteMembre::class)->nullable()->constrained()->onDelete('set null');

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
        Schema::dropIfExists('lot_cartes');
    }
};
