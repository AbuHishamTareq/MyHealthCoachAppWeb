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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->string('name');
            $table->string('password');
            $table->string('mobile');
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('blood_group')->nullable();
            $table->integer('coach_id');
            $table->integer('complex_id');
            $table->date('birth_date');
            $table->tinyInteger('status')->default(0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
