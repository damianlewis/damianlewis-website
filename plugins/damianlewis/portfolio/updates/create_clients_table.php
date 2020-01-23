<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateClientsTable extends Migration
{
    public function up(): void
    {
        Schema::create('damianlewis_portfolio_clients', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->unsignedSmallInteger('logo_width')->nullable();
            $table->unsignedSmallInteger('logo_opacity')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('damianlewis_portfolio_clients');
    }
}
