<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplies', function (Blueprint $table) {
            $table->id();
            $table->string('item');
            $table->string('unit');
            $table->integer('quantity');
            $table->decimal('unit_cost', 10, 2);
            $table->string('supply_from');
            $table->integer('supply_from_quantity');
            $table->integer('reorder_threshold')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplies');
    }
};
