<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class HideServicesInServicesList extends Migration
{
    public function up()
    {
        Schema::table('damianlewis_portfolio_services', function (Blueprint $table) {
            $table->boolean('is_hidden_in_list')->default(false);
        });
    }

    public function down()
    {
        if (Schema::hasColumn('damianlewis_portfolio_services', 'is_hidden_in_list')) {
            Schema::table('damianlewis_portfolio_services', function (Blueprint $table) {
                $table->dropColumn('is_hidden_in_list');
            });
        }
    }
}