<?php

namespace Corals\Modules\Shortener\database\seeds;

use Corals\Menu\Models\Menu;
use Corals\Settings\Models\Setting;
use Corals\User\Models\Permission;
use Corals\User\Models\Role;
use Illuminate\Database\Seeder;
use \Spatie\MediaLibrary\MediaCollections\Models\Media;

class ShortenerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ShortenerPermissionsDatabaseSeeder::class);
        $this->call(ShortenerMenuDatabaseSeeder::class);
        $this->call(ShortenerSettingsDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::query()->where('name', 'like', 'Shortener::%')
            ->orWhere('name', 'Administrations::admin.shortener')
            ->delete();

        Role::query()
            ->where('name', 'shortener-client')
            ->delete();

        Menu::query()->where('key', 'shortener')
            ->orWhere('active_menu_url', 'like', 'shortener%')
            ->orWhere('url', 'like', 'shortener%')
            ->delete();

        Setting::query()->where('category', 'Shortener')->delete();

        Media::query()->whereIn('collection_name', ['shortener-media-collection'])->delete();
    }
}
