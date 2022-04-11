<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentEmpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_emps', function (Blueprint $table) {
            $table->id();
            $table->integer('assessment_id')->nullable();
            $table->integer('assessment_group_id')->nullable();
            $table->integer('assessment_from_id')->nullable(); 
            $table->integer('level_id')->nullable(); 
            $table->integer('employees_id')->comment(' ผู้ถูกประเมิน '); 
            
            $table->text('note')->nullable();   
            $table->char('status', 1)->default(1)->nullable()->comment(' 1=รอการประเมินผล / 2=การประเมินผลสำเร็จ / 3=ส่งกลับแก้ไข'); 
            $table->string('password')->nullable();
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
        Schema::dropIfExists('assessment_emps');
    }
}
