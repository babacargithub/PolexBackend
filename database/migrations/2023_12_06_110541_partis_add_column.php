<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends  Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        //
        Schema::table('partis',function (Blueprint $table){
            $table->boolean("has_debt")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('partis',function (Blueprint $table){
            $table->dropColumn("has_debt");
        });
    }
};
