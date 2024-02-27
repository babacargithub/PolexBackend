<?php

use App\Models\Sondage;
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
        Schema::create('question_sondages', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable(false);
            $table->boolean('multiple')->default(false);
            $table->foreignIdFor(Sondage::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['libelle', 'sondage_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_sondages');
    }
};
