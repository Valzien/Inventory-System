<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'atasan', 'manpurchase', 'direktur') NOT NULL DEFAULT 'admin'");
        DB::statement("UPDATE users SET role = 'manpurchase' WHERE role = 'atasan'");
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'manpurchase', 'direktur') NOT NULL DEFAULT 'admin'");
    }

    public function down(): void
    {
        DB::statement("UPDATE users SET role = 'atasan' WHERE role = 'manpurchase'");
        DB::statement("UPDATE users SET role = 'admin' WHERE role NOT IN ('admin', 'atasan')");
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'atasan') NOT NULL DEFAULT 'admin'");
    }
};
