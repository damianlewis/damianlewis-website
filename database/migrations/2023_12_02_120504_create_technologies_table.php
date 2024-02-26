<?php

use App\Models\Technology;
use App\Models\TechnologyCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $modelTable = (new Technology)->getTable();

        Schema::create($modelTable, function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(TechnologyCategory::class)
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
            $table->foreignIdFor(Technology::class, 'parent_id')
                ->after('technology_category_id')
                ->nullable()
                ->constrained($modelTable)
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists((new Technology)->getTable());
    }
};
