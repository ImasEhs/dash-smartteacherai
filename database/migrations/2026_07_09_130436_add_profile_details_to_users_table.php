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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone_number')) $table->string('phone_number')->nullable();
            if (!Schema::hasColumn('users', 'profesi')) $table->string('profesi')->nullable();
            if (!Schema::hasColumn('users', 'bidang')) $table->string('bidang')->nullable();
            if (!Schema::hasColumn('users', 'institusi')) $table->string('institusi')->nullable();
            if (!Schema::hasColumn('users', 'tingkat_pendidikan')) $table->string('tingkat_pendidikan')->nullable();
            if (!Schema::hasColumn('users', 'target_karir')) $table->string('target_karir')->nullable();
            if (!Schema::hasColumn('users', 'target_mingguan')) $table->integer('target_mingguan')->nullable();
            if (!Schema::hasColumn('users', 'minat_pembelajaran')) $table->string('minat_pembelajaran')->nullable();
            if (!Schema::hasColumn('users', 'is_active')) $table->boolean('is_active')->default(true);
            if (!Schema::hasColumn('users', 'avatar')) $table->string('avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
