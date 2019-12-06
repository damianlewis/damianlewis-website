<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateAttributesTable extends Migration
{
    public function up()
    {
        Schema::create('damianlewis_portfolio_attributes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type');
            $table->string('name');
            $table->string('label')->nullable();
            $table->string('code');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('damianlewis_portfolio_attributes');
    }
}
