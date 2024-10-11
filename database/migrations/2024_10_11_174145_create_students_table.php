<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->foreignId('group_id')->constrained()->onDelete('cascade'); // Foreign key referencing groups table
            $table->string('student_name');
            $table->string('student_email');
            $table->string('phone_number');
            $table->string('course');
            $table->string('year_course');
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
}
