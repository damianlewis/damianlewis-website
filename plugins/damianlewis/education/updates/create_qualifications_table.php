<?php

declare(strict_types=1);

namespace DamianLewis\Education\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateQualificationsTable extends Migration
{
    public function up()
    {
        Schema::create('damianlewis_education_qualifications', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('score')->nullable();
            $table->unsignedSmallInteger('sort_order')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('damianlewis_education_qualifications');
    }
}
