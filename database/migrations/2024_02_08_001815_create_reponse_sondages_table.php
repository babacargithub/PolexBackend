<?php

use App\Models\QuestionSondage;
use App\Models\Reponse;
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
        Schema::create('reponse_sondages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(QuestionSondage::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Reponse::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('is_valid')->default(true);
            $table->string('reference')->nullable();
            $table->timestamps();
            $table->unique(['question_sondage_id', 'reponse_id','reference']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reponse_sondages');
    }
};
