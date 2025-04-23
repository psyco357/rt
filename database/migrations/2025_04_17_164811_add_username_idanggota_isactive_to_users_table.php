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
            $table->string('username')->unique()->after('email_verified_at');
            $table->unsignedBigInteger('idanggota')->nullable()->after('id');
            $table->unsignedBigInteger('role')->nullable()->after('remember_token');
            $table->integer('isactive')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'idanggota', 'isactive', 'role']);
        });
    }
};
