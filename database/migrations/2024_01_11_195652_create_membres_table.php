<?php

use App\Models\Structure;
use App\Models\TypeMembre;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('membres', function (Blueprint $table) {
            $table->id();
            $table->string('prenom')->nullable(false);
            $table->string('nom')->nullable(false);
            $table->string('telephone')->nullable(false);
            $table->char('sexe', 1)->nullable(); // Assuming sexe is either 'M' or 'F'
            $table->string('nin')->nullable(false)->unique(); // Assuming NIN is a string
            $table->string('commune')->nullable(false);
            $table->boolean('is_electeur')->default(false);
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade');
            // type membre
            $table->foreignIdFor(TypeMembre::class)->nullable()->constrained()->onDelete('cascade');
            // structure
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
        Schema::dropIfExists('membres');
    }
}
