<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateSkillsTable extends Migration
{
    public function up(): void
    {
        Schema::create('damianlewis_portfolio_skills', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable()->index();
            $table->unsignedInteger('category_id')->nullable()->index();
            $table->string('name')->nullable()->unique();
            $table->unsignedSmallInteger('sort_order')->nullable();
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('damianlewis_portfolio_skills');

            $table->foreign('category_id')
                ->references('id')
                ->on('damianlewis_portfolio_categories');
        });
    }

    public function down(): void
    {
        Schema::table('damianlewis_portfolio_skills', function (Blueprint $table) {
            $table->dropForeign('damianlewis_portfolio_skills_parent_id_foreign');
        });

        Schema::table('damianlewis_portfolio_skills', function (Blueprint $table) {
            $table->dropForeign('damianlewis_portfolio_skills_category_id_foreign');
        });

        Schema::dropIfExists('damianlewis_portfolio_skills');
    }
}
