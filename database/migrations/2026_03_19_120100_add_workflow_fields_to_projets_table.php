<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('type');
            $table->unsignedTinyInteger('progress')->default(0)->after('status');
            $table->text('admin_feedback')->nullable()->after('progress');
            $table->timestamp('approved_at')->nullable()->after('admin_feedback');
        });

        DB::table('projets')->update([
            'status' => 'approved',
            'progress' => 100,
            'approved_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropColumn(['status', 'progress', 'admin_feedback', 'approved_at']);
        });
    }
};
