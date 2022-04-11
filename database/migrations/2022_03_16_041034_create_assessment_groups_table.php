<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessment_groups', function (Blueprint $table) {
            $table->id();
            $table->integer('assessment_id')->nullable(); 
            $table->integer('level_id')->nullable();
            $table->string('name')->nullable(); 
            $table->text('detail')->nullable();  
            $table->integer('employees_id')->comment(' ผู้ประเมินกลุ่ม ');
            $table->char('status', 1)->default(1)->nullable()->comment(' 1=รอการประเมินผล / 2=การประเมินผลสำเร็จ / 3=ส่งกลับแก้ไข');
            $table->string('email')->nullable(); 
            $table->char('send_mail', 1)->default('N')->nullable()->comment(' Y/N '); 
            $table->char('tems_status', 1)->default('Y')->nullable()->comment(' Y/N ');
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
        Schema::dropIfExists('assessment_groups');
    }
}
