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
        Schema::create('patient_parameters', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id');
            $table->integer('bp_systolic')->nullable();
            $table->integer('bp_distolic')->nullable();
            $table->integer('rbs')->nullable();
            $table->float('weight')->nullable();
            $table->float('bmi')->nullable();
            $table->date('read_date');
            $table->time('read_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_parameters');
    }
};
