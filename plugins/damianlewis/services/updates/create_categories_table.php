<?php

declare(strict_types=1);

namespace DamianLewis\Services\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('damianlewis_services_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->index();
            $table->text('featured_text')->nullable();
            $table->text('hero_text')->nullable();
            $table->text('list_text')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('damianlewis_services_categories');
    }
}
