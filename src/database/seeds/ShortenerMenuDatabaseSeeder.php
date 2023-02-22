<?php

namespace Corals\Modules\Shortener\database\seeds;

use Corals\User\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShortenerMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shortenerClientRole = Role::findByName('shortener-client');

        $shortener_menu_id = DB::table('menus')->insertGetId([
            'parent_id' => 1,// admin
            'key' => 'shortener',
            'url' => null,
            'active_menu_url' => 'shortener*',
            'name' => 'URL Shortener',
            'description' => 'URL Shortener Menu Item',
            'icon' => 'fa fa-ellipsis-h',
            'target' => null,
            'roles' => '["1","' . $shortenerClientRole->id . '"]',
            'order' => 0,
        ]);

        // seed children menu
        DB::table('menus')->insert(
            [
                [
                    'parent_id' => $shortener_menu_id,
                    'key' => null,
                    'url' => config('shortener.models.shortDomain.resource_url'),
                    'active_menu_url' => config('shortener.models.shortDomain.resource_url') . '*',
                    'name' => 'Short Domains',
                    'description' => 'Short Domains List Menu Item',
                    'icon' => 'fa fa-globe',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0,
                ],
                [
                    'parent_id' => $shortener_menu_id,
                    'key' => null,
                    'url' => config('shortener.models.link.resource_url'),
                    'active_menu_url' => config('shortener.models.link.resource_url') . '*',
                    'name' => 'Links',
                    'description' => 'Links List Menu Item',
                    'icon' => 'fa fa-link',
                    'target' => null,
                    'roles' => '["1","' . $shortenerClientRole->id . '"]',
                    'order' => 0,
                ],
                [
                    'parent_id' => $shortener_menu_id,
                    'key' => null,
                    'url' => config('shortener.models.impression.resource_url'),
                    'active_menu_url' => config('shortener.models.impression.resource_url') . '*',
                    'name' => 'Impressions',
                    'description' => 'Impressions List Menu Item',
                    'icon' => 'fa fa-list',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0,
                ],

                [
                    'parent_id' => $shortener_menu_id,
                    'key' => null,
                    'url' => config('shortener.models.tracking_pixel.resource_url'),
                    'active_menu_url' => config('shortener.models.tracking_pixel.resource_url') . '*',
                    'name' => 'Tracking Pixels',
                    'description' => 'Tracking Pixels List Menu Item',
                    'icon' => 'fa fa-th',
                    'target' => null,
                    'roles' => '["1"]',
                    'order' => 0,
                ],
            ]
        );
    }
}
