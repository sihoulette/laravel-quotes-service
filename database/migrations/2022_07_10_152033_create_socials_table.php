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
        Schema::create('socials', function (Blueprint $table) {
            $table->string('alias')->unique()->comment('Api alias');
            $table->string('name')->unique()->comment('Name');
            $table->string('fa_brand')->unique()->comment('Fontawesome icon');
            $table->tinyInteger('active')->default(1)->comment('Enable status');
            $table->smallInteger('position')->default(0)->comment('Order position');
            $table->timestamps();

            $table->primary('alias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socials');
    }
};
