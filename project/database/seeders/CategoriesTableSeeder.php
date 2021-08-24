<?php

namespace Database\Seeders;

use App\DbModels\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Компьютеры',
                'code' => 'computers',
                'sort' => '100',
            ],
            [
                'name' => 'Холодильники',
                'code' => 'friges',
                'sort' => '200',
            ],
            [
                'name' => 'Телефоны',
                'code' => 'phones',
                'sort' => '300',
            ],
            [
                'name' => 'Переферия',
                'code' => 'peripheries',
                'sort' => '400',
            ],
            [
                'name' => 'Фото камеры',
                'code' => 'photos',
                'sort' => '500',
            ],
        ];

        $children = [
            'computers' => [
                [
                    'name' => 'Стационарные',
                    'code' => 'station',
                    'sort' => '110',
                ],
                [
                    'name' => 'Ноутбуки',
                    'code' => 'laptops',
                    'sort' => '120',
                ],
                [
                    'name' => 'Рабочие станции',
                    'code' => 'workstations',
                    'sort' => '130',
                ],
            ],
            'photos' => [
                [
                    'name' => 'Фотоаппараты',
                    'code' => 'photo-technic',
                    'sort' => '510',
                ],
                [
                    'name' => 'Видеокамеры',
                    'code' => 'video-technic',
                    'sort' => '520',
                ],
                [
                    'name' => 'Объективы',
                    'code' => 'lenses',
                    'sort' => '530',
                ],
            ],
        ];

        $parentCategories = [];
        foreach ($categories as $category) {
            $parent = Category::create($category);
            $parentCategories[$parent->code] = $parent->id;
        }

        foreach ($children as $code => $children) {
            if ($parentCategories[$code]) {
                foreach ($children as $item) {
                    Category::create(array_merge($item, ['parent' => $parentCategories[$code]]));
                }
            }
        }
    }
}
