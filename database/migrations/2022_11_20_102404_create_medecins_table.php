<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedecinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medecins', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->string('medecin_name');
            $table->string('speciality');

            $table->text('address');
            $table->string('phone');
            $table->string('email');
            $table->integer('nb_reviews')->unsigned()->default(0);
            
            $table->decimal('gps_lat',12,10)->default(0)->nullable();
            $table->decimal('gps_lng',12,10)->default(0)->nullable();
            $table->integer('validation_status_medecin')->unsigned()->default(3);

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('medecins');
    }
}
