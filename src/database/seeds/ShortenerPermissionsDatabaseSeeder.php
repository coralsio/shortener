<?php

namespace Corals\Modules\Shortener\database\seeds;

use Carbon\Carbon;
use Corals\User\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ShortenerPermissionsDatabaseSeeder extends Seeder
{
    protected $models = [
        'link',
        'shortDomain',
        'impression',
        'tracking_pixel'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [];

        foreach ($this->models as $model) {
            $permissions[] = $this->generatePermissionArray($model);
        }

        $permissions = Arr::flatten($permissions, 1);

        DB::table('permissions')->insert(
            array_merge($permissions, [
                [
                    'name' => 'Administrations::admin.shortener',
                    'guard_name' => config('auth.defaults.guard'),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            ])
        );


        $shortenerClientRole = Role::query()->create([
            'name' => 'shortener-client',
            'label' => 'Shortener Client',
        ]);


        $shortenerClientRole->givePermissionTo([
            'Shortener::link.create',
            'Shortener::link.view',
            'Notification::my_notification.view',
            'Notification::my_notification.update',
            'Notification::my_notification.delete',
        ]);
    }

    /**
     * @param $modelKey
     * @return array
     */
    protected function generatePermissionArray($modelKey)
    {
        $permissions = [];

        foreach (['view', 'create', 'update', 'delete'] as $action) {
            $permissions[] = [
                'name' => "Shortener::$modelKey.$action",
                'guard_name' => config('auth.defaults.guard'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }


        return $permissions;
    }
}
