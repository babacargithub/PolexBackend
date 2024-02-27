<?php

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
        Schema::create('organigrammes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TypeMembre::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->json('subordinates')->nullable();
            $table->string('type_organigramme')->nullable();
            $table->integer('position');
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
        Schema::dropIfExists('organigrammes');
    }
};
