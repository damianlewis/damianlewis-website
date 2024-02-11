<?php

use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $modelTable = (new Skill())->getTable();

        Schema::create($modelTable, function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(SkillCategory::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->boolean('enabled')->default(false);
            $table->unsignedInteger(config('eloquent-sortable.order_column_name'));
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table($modelTable, function (Blueprint $table) use ($modelTable) {
            $table->foreignIdFor(Skill::class, 'parent_id')
                ->after('skill_category_id')
                ->nullable()
                ->constrained($modelTable)
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists((new Skill)->getTable());
    }
};
