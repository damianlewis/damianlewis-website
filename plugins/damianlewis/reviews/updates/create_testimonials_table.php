<?php

declare(strict_types=1);

namespace DamianLewis\Reviews\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTestimonialsTable extends Migration
{
    public function up(): void
    {
        Schema::create('damianlewis_reviews_testimonials', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->text('quote')->nullable();
            $table->unsignedSmallInteger('rating')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('damianlewis_reviews_testimonials');
    }
}
