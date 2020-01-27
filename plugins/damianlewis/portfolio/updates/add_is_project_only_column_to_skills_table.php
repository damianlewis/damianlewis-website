<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class AddIsProjectOnlyColumnToSkillsTable extends Migration
{
    public function up()
    {
        Schema::table('damianlewis_portfolio_skills', function (Blueprint $table) {
            $table->boolean('is_project_only')->default(false)->after('is_hidden');
        });
    }

    public function down()
    {
        if (Schema::hasColumn('damianlewis_portfolio_skills', 'is_hidden_in_list')) {
            Schema::table('damianlewis_portfolio_skills', function (Blueprint $table) {
                $table->dropColumn('is_project_only');
            });
        }
    }
}