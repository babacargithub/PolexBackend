<?php

use App\Models\LotCarte;
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
    public function up(): void
    {
        //
        Schema::table('carte_membres', function (Blueprint $table) {
            $table->foreignIdFor(LotCarte::class)->nullable()->constrained()->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        //
        Schema::table("carte_membres", function (Blueprint $table) {
            $table->dropForeignIdFor(LotCarte::class);
        });
    }
};
