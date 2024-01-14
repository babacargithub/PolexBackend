<?php

use App\Models\Membre;
use App\Models\Structure;
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
        Schema::create('carte_membres', function (Blueprint $table) {
            $table->id();
            $table->string("numero")->nullable(false)->unique();
            $table->foreignIdFor(Membre::class)->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Structure::class)->nullable()->constrained()->onDelete('cascade');
            $table->boolean("vendue")->default(false);
            $table->foreignIdFor(TypeCarteMembre::class)->nullable()->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('carte_membres');
    }
};
