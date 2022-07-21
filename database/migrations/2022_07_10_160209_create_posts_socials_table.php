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
        Schema::create('posts_socials', function (Blueprint $table) {
            $table->bigInteger('post_id', false, true)->comment('Post');
            $table->string('social_alias')->comment('Api alias');
            $table->bigInteger('share_count', false, true)->comment('Share count');
            $table->timestamps();

            $table->primary(['post_id', 'social_alias']);
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('social_alias')
                ->references('alias')
                ->on('socials')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts_socials');
    }
};
