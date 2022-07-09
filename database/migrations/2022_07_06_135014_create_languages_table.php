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
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->string('locale')->comment('Locale');
            $table->string('name')->comment('Name');
            $table->string('native')->comment('Native name');
            $table->string('regional')->comment('Regional');
            $table->tinyInteger('active')->default(1)->comment('Enable status');
            $table->tinyInteger('default')->default(0)->comment('Default status');
            $table->smallInteger('position')->default(0)->comment('Order position');
            $table->timestamps();

            $table->primary('locale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
};
