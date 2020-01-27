<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

class AddIsFeaturedColumnToTestimonialsTable extends Migration
{
    public function up()
    {
        if (Schema::hasColumn('damianlewis_portfolio_testimonials', 'is_active')) {
            Schema::table('damianlewis_portfolio_testimonials', function (Blueprint $table) {
                $table->dropColumn('is_active');
            });
        }

        Schema::table('damianlewis_portfolio_testimonials', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('rating');
        });
    }

    public function down()
    {
        if (Schema::hasColumn('damianlewis_portfolio_testimonials', 'is_featured')) {
            Schema::table('damianlewis_portfolio_testimonials', function (Blueprint $table) {
                $table->dropColumn('is_featured');
            });
        }
    }
}