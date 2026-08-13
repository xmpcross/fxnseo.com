<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class OptimizePublicNavigationForSeo extends Migration
{
    public function up()
    {
        $now = now();

        DB::table('menus')->where('id', 152)->update(['text' => 'SEO Tools', 'sort' => 1, 'updated_at' => $now]);
        DB::table('menus')->where('id', 64)->update(['sort' => 2, 'updated_at' => $now]);
        DB::table('menus')->where('id', 96)->update(['text' => 'Content Tools', 'sort' => 3, 'updated_at' => $now]);
        DB::table('menus')->where('id', 153)->update(['sort' => 5, 'updated_at' => $now]);
        DB::table('menus')->where('id', 154)->update(['sort' => 6, 'updated_at' => $now]);

        DB::table('menus')->updateOrInsert(
            ['parent_id' => 152, 'text' => 'All SEO Tools'],
            ['url' => 'tools', 'menu_items' => null, 'icon' => 'fas fa-th-large', 'type' => 'link', 'class' => null, 'sort' => 0, 'target' => '_self', 'updated_at' => $now, 'created_at' => $now]
        );

        $guides = DB::table('menus')->where('parent_id', 0)->where('text', 'SEO Guides')->first();
        $guidesId = $guides ? $guides->id : DB::table('menus')->insertGetId([
            'text' => 'SEO Guides', 'url' => '#', 'menu_items' => 'custom',
            'icon' => 'fas fa-book-open', 'type' => 'link', 'class' => null,
            'parent_id' => 0, 'sort' => 4, 'target' => '_self',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        $items = [
            ['The Complete Guide to Backlink Monitoring', 'backlink-monitoring-guide', 'fas fa-link', 1],
            ['Link Building Opportunity Guide', 'link-opportunity-guide', 'fas fa-search', 2],
            ['SEO Audit & Reporting Hub', 'seo-audit-guide', 'fas fa-chart-line', 3],
        ];
        foreach ($items as [$text, $url, $icon, $sort]) {
            DB::table('menus')->updateOrInsert(
                ['parent_id' => $guidesId, 'url' => $url],
                ['text' => $text, 'menu_items' => null, 'icon' => $icon, 'type' => 'link', 'class' => null, 'sort' => $sort, 'target' => '_self', 'updated_at' => $now, 'created_at' => $now]
            );
        }
    }

    public function down()
    {
        DB::table('menus')->where('parent_id', 152)->where('text', 'All SEO Tools')->delete();
        $guides = DB::table('menus')->where('parent_id', 0)->where('text', 'SEO Guides')->first();
        if ($guides) {
            DB::table('menus')->where('parent_id', $guides->id)->delete();
            DB::table('menus')->where('id', $guides->id)->delete();
        }
        DB::table('menus')->where('id', 64)->update(['sort' => 1]);
        DB::table('menus')->where('id', 96)->update(['text' => 'Text Analysis Tools', 'sort' => 2]);
        DB::table('menus')->where('id', 152)->update(['text' => 'Website Tools', 'sort' => 3]);
        DB::table('menus')->where('id', 153)->update(['sort' => 4]);
        DB::table('menus')->where('id', 154)->update(['sort' => 5]);
    }
}
