<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');//
            $table->integer('price')->default(0);
            $table->integer('hours')->default(0);//
            $table->text('course_image')->nullable();
            $table->integer('seats')->default(0);
            $table->string('description');//
            $table->boolean('hasExam')->default(false);
            $table->boolean('active')->default(false);//0 mean not published yet
            $table->string('language'); 
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('academy_id')->constrained('academies')->cascadeOnDelete();
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
        Schema::dropIfExists('courses');
    }
}
