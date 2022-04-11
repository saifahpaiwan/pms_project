<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentFormDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_form_details', function (Blueprint $table) {
            $table->id();
            $table->integer('forms_id');
            $table->string('name'); 
            $table->float('average', 8, 2); 
            $table->char('type', 1)->default(1)->nullable()->comment('1=ใส่คะแนน / 2=ใส่คำอธิบาย');
            $table->timestamps();
            $table->char('deleted_at', 1)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_form_details');
    }
}
