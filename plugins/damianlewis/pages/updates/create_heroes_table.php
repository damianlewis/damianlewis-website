<?php

declare(strict_types=1);

namespace DamianLewis\Pages\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateHeroesTable extends Migration
{
    public function up()
    {
        Schema::create('damianlewis_pages_heroes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('description');
            $table->string('header');
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('damianlewis_pages_heroes');
    }
}
