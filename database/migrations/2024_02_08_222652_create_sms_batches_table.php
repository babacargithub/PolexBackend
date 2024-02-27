<?php

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
        Schema::create('sms_batches', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable(false);
            $table->mediumText('message')->nullable(false);
            $table->integer('total')->nullable(false);
            $table->string('status')->nullable(false);
            $table->boolean('sent_all')->nullable(false)->default(false);
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
        Schema::dropIfExists('sms_batches');
    }
};
