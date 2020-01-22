<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('damianlewis_portfolio_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable()->index();
            $table->string('name')->nullable();
            $table->unsignedSmallInteger('sort_order')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('damianlewis_portfolio_categories');
        });
    }

    public function down()
    {
        Schema::table('damianlewis_portfolio_categories', function (Blueprint $table) {
            $table->dropForeign('damianlewis_portfolio_categories_parent_id_foreign');
        });

        Schema::dropIfExists('damianlewis_portfolio_categories');
    }
}
