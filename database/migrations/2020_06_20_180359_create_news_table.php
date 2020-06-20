<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('user_type');
            $table->integer('news_type');
            $table->text('title_ar')->nullable();
            $table->text('title_en')->nullable();
            $table->text('text_ar')->nullable();
            $table->text('text_en')->nullable();
            $table->string('img')->nullable();
            $table->boolean('active')->default(false);
            $table->integer('active_days');
            $table->integer('order')->default(0);
            $table->string('youtube')->nullable();
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
        Schema::dropIfExists('news');
    }
}
