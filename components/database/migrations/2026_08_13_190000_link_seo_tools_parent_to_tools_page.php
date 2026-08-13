<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class LinkSeoToolsParentToToolsPage extends Migration
{
    public function up()
    {
        DB::table('menus')->where('id', 152)->update([
            'url' => 'tools',
            'menu_items' => null,
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        DB::table('menus')->where('id', 152)->update([
            'url' => '#',
            'menu_items' => 'custom',
        ]);
    }
}
