<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobDescriptionsTable extends Migration
{
    public function up()
    {
        Schema::create('job_descriptions', function (Blueprint $table) {
            $table->id();
            // user_id references users.id; cascade on delete
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->string('job_title');
            $table->string('skills');
            $table->string('industry');
            $table->string('experience');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_descriptions');
    }
}
