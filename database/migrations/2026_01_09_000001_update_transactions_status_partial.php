<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'status_changed_at')) {
                $table->timestamp('status_changed_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('transactions', 'status_note')) {
                $table->text('status_note')->nullable()->after('status_changed_at');
            }
        });

        DB::statement("ALTER TABLE transactions MODIFY status ENUM('pending','partial','success','failed','cancelled') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transactions MODIFY status ENUM('pending','success','failed','cancelled') DEFAULT 'pending'");

        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'status_changed_at')) {
                $table->dropColumn('status_changed_at');
            }
            if (Schema::hasColumn('transactions', 'status_note')) {
                $table->dropColumn('status_note');
            }
        });
    }
};
