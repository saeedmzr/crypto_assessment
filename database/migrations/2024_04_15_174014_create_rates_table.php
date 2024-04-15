<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('origin_currency_id');
            $table->unsignedBigInteger('destination_currency_id');
            $table->float("ratio")->default(1);
            $table->boolean("internal")->default(false);

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('origin_currency_id')
                ->references('id')
                ->on('currencies')
                ->onDelete('cascade');

            $table->foreign('destination_currency_id')
                ->references('id')
                ->on('currencies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
