<?php

declare(strict_types=1);

namespace DamianLewis\Portfolio\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTestimonialsTable extends Migration
{
    public function up(): void
    {
        Schema::create('damianlewis_portfolio_testimonials', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('project_id')->nullable()->index();
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->text('quote')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('damianlewis_portfolio_testimonials');
    }
}
