<?php

use App\Models\TechnologyCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create((new TechnologyCategory)->getTable(), function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('enabled')->default(false);
            $table->unsignedInteger(config('eloquent-sortable.order_column_name'));
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists((new TechnologyCategory)->getTable());
    }
};
