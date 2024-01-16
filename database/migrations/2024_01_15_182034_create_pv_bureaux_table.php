<?php

use App\Models\Bureau;
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
        Schema::create('pv_bureaux', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Bureau::class)->nullable(false)->unique()->constrained('bureaux')->onDelete('cascade');
            $table->integer('inscrits')->nullable(false);
            $table->integer('votants')->nullable();
            $table->integer('suffrages_exprimes')->nullable();
            $table->integer('bulletins_nuls')->nullable();
            $table->text('commentaire')->nullable();
            $table->string("photo_pv")->nullable();
            $table->boolean("certifie")->default(false);
//            $table->foreignId('bureau_id')->nullable(false)->constrained("bureaux")->onDelete('cascade');
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
        Schema::dropIfExists('pv_bureaux');
    }
};
