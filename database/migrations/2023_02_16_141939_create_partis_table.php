<?php

use App\Models\Formule;
use App\Models\User;
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
        Schema::create('partis', function (Blueprint $table) {
            $table->id();
            $table->string("nom")->nullable(false);
            $table->string("code")->unique();
            $table->foreignIdFor(Formule::class)->nullable()->constrained();
            $table->foreignIdFor(User::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('partis');
    }
};
