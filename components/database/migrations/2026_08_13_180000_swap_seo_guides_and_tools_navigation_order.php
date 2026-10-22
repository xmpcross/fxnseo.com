<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SwapSeoGuidesAndToolsNavigationOrder extends Migration
{
    public function up()
    {
        DB::table('menus')->where('parent_id', 0)->where('text', 'SEO Guides')->update(['sort' => 1, 'updated_at' => now()]);
        DB::table('menus')->where('id', 152)->update(['sort' => 2, 'updated_at' => now()]);
    }

    public function down()
    {
        DB::table('menus')->where('id', 152)->update(['sort' => 1]);
        DB::table('menus')->where('parent_id', 0)->where('text', 'SEO Guides')->update(['sort' => 4]);
    }
}
