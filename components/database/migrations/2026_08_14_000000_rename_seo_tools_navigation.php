<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('menus')
            ->where('parent_id', 0)
            ->where('url', 'tools')
            ->update([
                'text' => 'All SEO Tools',
                'icon' => 'fas fa-tools',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        DB::table('menus')
            ->where('parent_id', 0)
            ->where('url', 'tools')
            ->update([
                'text' => 'SEO Tools',
                'icon' => null,
                'updated_at' => now(),
            ]);
    }
};
