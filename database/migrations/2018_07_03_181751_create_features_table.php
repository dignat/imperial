<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->increments('feature_id');
            $table->string('feature');
            $table->unsignedInteger('car_id');
            $table->float('price')->nullable();
            $table->foreign('car_id')
                ->references('id')->on('cars')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamp('createdAt')->useCurrent();
            $table->timestamp('updatedAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('features');
    }
}
