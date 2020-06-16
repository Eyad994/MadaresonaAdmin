<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_type');
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->integer('school_order');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->string('principle_title_ar')->nullable();
            $table->string('principle_title_en')->nullable();
            $table->text('principle_ar')->nullable();
            $table->text('principle_en')->nullable();
            $table->text('school_details_ar')->nullable();
            $table->text('school_details_en')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('po_box')->nullable();
            $table->string('school_logo')->nullable();
            $table->string('country')->default('Jordan');
            $table->integer('city')->unsigned()->nullable();
            $table->integer('region')->unsigned()->nullable();
            $table->string('brochure')->nullable();
            $table->text('facebook_link')->nullable();
            $table->text('twitter_link')->nullable();
            $table->text('instagram_link')->nullable();
            $table->text('linkedin_link')->nullable();
            $table->text('lat')->nullable();
            $table->text('lng')->nullable();
            $table->boolean('curriculum_ls_local')->default(false)->nullable();
            $table->boolean('curriculum_ls_public')->default(false)->nullable();
            $table->boolean('discounts_superior')->default(false)->nullable();
            $table->boolean('discounts_quran')->default(false)->nullable();
            $table->boolean('discounts_sport')->default(false)->nullable();
            $table->boolean('discounts_brothers')->default(false)->nullable();
            $table->integer('gender')->nullable();
            $table->boolean('madaresona_discounts')->default(false)->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('contact_person_email')->nullable();
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
        Schema::dropIfExists('schools');
    }
}
