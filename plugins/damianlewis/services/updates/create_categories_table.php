<?php

declare(strict_types=1);

namespace DamianLewis\Services\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('damianlewis_services_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable()->index();
            $table->text('featured_text')->nullable();
            $table->text('hero_text')->nullable();
            $table->text('list_text')->nullable();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('sort_order')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('damianlewis_services_categories');
    }
}
