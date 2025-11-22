<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('log_aktivitas', function (Blueprint $table) {
            if (!Schema::hasColumn('log_aktivitas', 'aktivitas')) {
                $table->string('aktivitas')->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('log_aktivitas', function (Blueprint $table) {
            $table->dropColumn('aktivitas');
        });
    }
};