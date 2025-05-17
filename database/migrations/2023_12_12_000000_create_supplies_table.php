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
            $table->decimal('purchase_supplies', 10, 2);
            $table->decimal('received_supplies', 10, 2);
            $table->decimal('inventory_end', 10, 2);
            $table->integer('issued');
            $table->decimal('unit_cost', 10, 2);
            $table->decimal('amount', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplies');
    }
};
