<?php

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
        Schema::create('lot_cartes', function (Blueprint $table) {
            $table->id();
            $table->string("numero")->nullable(false)->unique();
            $table->foreignIdFor(Membre::class)->nullable()->constrained()->onDelete('cascade');
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
