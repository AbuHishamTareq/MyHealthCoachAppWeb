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
        Schema::table('admins', function (Blueprint $table) {
            $table->string('uid')->unique()->nullable()->after('id');
            $table->string('address')->nullable()->after('name');
            $table->integer('complex_id')->nullable()->after('user_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('uid');
            $table->dropColumn('address');
            $table->dropColumn('complex_id');
        });
    }
};
