<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->unique();
            $table->enum('status', ['pending', 'accepted'])->default('pending');
            $table->string('office');
            $table->string('request_by');
            $table->string('request_by_designation');
            $table->timestamps();

            $table->string('received_by')->nullable();
            $table->timestamp('received_date')->nullable();
            $table->string('received_by_designation')->nullable();

            $table->string('released_by')->nullable();
            $table->timestamp('released_date')->nullable();
            $table->string('released_by_designation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
