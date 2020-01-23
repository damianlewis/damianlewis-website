<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateServicesTable extends Migration
{
    public function up()
    {
        Schema::create('damianlewis_portfolio_services', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('category_id')->nullable()->index();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('damianlewis_portfolio_categories');
        });
    }

    public function down()
    {
        Schema::table('damianlewis_portfolio_services', function (Blueprint $table) {
            $table->dropForeign('damianlewis_portfolio_services_category_id_foreign');
        });

        Schema::dropIfExists('damianlewis_portfolio_services');
    }
}
