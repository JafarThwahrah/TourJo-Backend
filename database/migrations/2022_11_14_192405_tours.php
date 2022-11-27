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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->double('tour_price');
            $table->text('tour_description');
            $table->text('tour_route');
            $table->date('tour_date');
            $table->integer('advisor_contact_number');
            $table->text('hero_img');
            $table->text('img_1');
            $table->text('img_2');
            $table->text('img_3');
            $table->text('img_4');
            $table->string('is_published')->default(true);
            $table->string('tour_rating')->default('uncalibrated');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
