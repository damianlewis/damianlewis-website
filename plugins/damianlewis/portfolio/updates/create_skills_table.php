<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateSkillsTable extends Migration
{
    public function up()
    {
        Schema::create('damianlewis_portfolio_skills', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->unique();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('damianlewis_portfolio_skills');
    }
}
