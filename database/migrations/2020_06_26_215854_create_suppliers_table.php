<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_type');
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->integer('supplier_order');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->text('location')->nullable();
            $table->text('supplier_details_ar')->nullable();
            $table->text('supplier_details_en')->nullable();
            $table->string('supplier_logo')->nullable();
            $table->string('country')->default('Jordan');
            $table->integer('city')->unsigned()->nullable();
            $table->integer('region')->unsigned()->nullable();
            $table->text('facebook_link')->nullable();
            $table->text('twitter_link')->nullable();
            $table->text('instagram_link')->nullable();
            $table->text('linkedin_link')->nullable();
            $table->text('googleplus_link')->nullable();
            $table->text('lat')->nullable();
            $table->text('lng')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
