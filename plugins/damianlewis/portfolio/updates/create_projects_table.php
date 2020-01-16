<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class CreateProjectsTable extends Migration
{
    public function up(): void
    {
        Schema::create('damianlewis_portfolio_projects', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('status_id')->nullable()->index();
            $table->string('title')->nullable();
            $table->string('slug')->nullable()->index();
            $table->string('tag_line')->nullable();
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('sort_order')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_hidden')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->foreign('status_id')
                ->references('id')
                ->on('damianlewis_portfolio_attributes');
        });

        Schema::create('damianlewis_portfolio_project_skill', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('skill_id');
            $table->primary([
                'project_id',
                'skill_id'
            ], 'damianlewis_portfolio_project_skill_primary');
            $table->timestamps();

            $table->foreign('project_id')
                ->references('id')
                ->on('damianlewis_portfolio_projects')
                ->onDelete('cascade');
            $table->foreign('skill_id')
                ->references('id')
                ->on('damianlewis_portfolio_skills')
                ->onDelete('cascade');
        });

        Schema::create('damianlewis_portfolio_project_technology', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('skill_id');
            $table->primary([
                'project_id',
                'skill_id'
            ], 'damianlewis_portfolio_project_technology_primary');
            $table->timestamps();

            $table->foreign('project_id')
                ->references('id')
                ->on('damianlewis_portfolio_projects')
                ->onDelete('cascade');
            $table->foreign('skill_id')
                ->references('id')
                ->on('damianlewis_portfolio_skills')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('damianlewis_portfolio_project_technology', function (Blueprint $table) {
            $table->dropForeign('damianlewis_portfolio_project_technology_project_id_foreign');
            $table->dropForeign('damianlewis_portfolio_project_technology_skill_id_foreign');
        });

        Schema::table('damianlewis_portfolio_project_skill', function (Blueprint $table) {
            $table->dropForeign('damianlewis_portfolio_project_skill_project_id_foreign');
            $table->dropForeign('damianlewis_portfolio_project_skill_skill_id_foreign');
        });

        Schema::table('damianlewis_portfolio_projects', function (Blueprint $table) {
            $table->dropForeign('damianlewis_portfolio_projects_status_id_foreign');
        });

        Schema::dropIfExists('damianlewis_portfolio_project_technology');
        Schema::dropIfExists('damianlewis_portfolio_project_skill');
        Schema::dropIfExists('damianlewis_portfolio_projects');
    }
}
