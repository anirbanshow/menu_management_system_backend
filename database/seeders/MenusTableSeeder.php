<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'id' => 10,
                'parent_id' => 8,
                'name' => 'menu_80',
                'menu_id' => 110
            ],
            [
                'id' => 11,
                'parent_id' => 8,
                'name' => 'menu_81',
                'menu_id' => 111
            ],

            [
                'id' => 12,
                'parent_id' => 9,
                'name' => 'menu_90',
                'menu_id' => 112
            ],
            [
                'id' => 13,
                'parent_id' => 9,
                'name' => 'menu_91',
                'menu_id' => 113
            ],
        ];

        Menu::insert($menus);

        // php artisan db:seed --class=MenusTableSeeder
    }
}
