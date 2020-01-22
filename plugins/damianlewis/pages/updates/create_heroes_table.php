<?php

declare(strict_types=1);

namespace DamianLewis\Pages\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateHeroesTable extends Migration
{
    public function up(): void
    {
        Schema::create('damianlewis_pages_heroes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('description')->nullable();
            $table->string('header')->nullable();
            $table->text('body')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('damianlewis_pages_heroes');
    }
}
