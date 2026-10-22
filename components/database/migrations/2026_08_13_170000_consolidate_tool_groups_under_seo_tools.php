<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ConsolidateToolGroupsUnderSeoTools extends Migration
{
    public function up()
    {
        $now = now();

        DB::table('menus')->where('id', 64)->update([
            'parent_id' => 152,
            'sort' => 1,
            'updated_at' => $now,
        ]);
        DB::table('menus')->where('id', 96)->update([
            'parent_id' => 152,
            'sort' => 2,
            'updated_at' => $now,
        ]);
        DB::table('menus')->where('id', 104)->update(['sort' => 3, 'updated_at' => $now]);
        DB::table('menus')->where('id', 120)->update(['sort' => 4, 'updated_at' => $now]);
    }

    public function down()
    {
        DB::table('menus')->where('id', 64)->update(['parent_id' => 0, 'sort' => 2]);
        DB::table('menus')->where('id', 96)->update(['parent_id' => 0, 'sort' => 3]);
        DB::table('menus')->where('id', 104)->update(['sort' => 1]);
        DB::table('menus')->where('id', 120)->update(['sort' => 2]);
    }
}
