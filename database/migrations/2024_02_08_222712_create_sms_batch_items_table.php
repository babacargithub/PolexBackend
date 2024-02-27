<?php

use App\Models\SmsBatch;
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
        Schema::create('sms_batch_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SmsBatch::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->bigInteger('telephone')->nullable(false);
            $table->mediumText('message')->nullable(false);
            $table->boolean('sent')->default(false);
            $table->boolean('failed')->default(false);
            $table->dateTime('sent_at')->nullable();
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
        Schema::dropIfExists('sms_batch_items');
    }
};
