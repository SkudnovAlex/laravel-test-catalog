<?php

namespace Database\Seeders;

use App\DbModels\Category;
use App\DbModels\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cat1 = Category::query()->where('code', 'laptops')->get()->first();
        $products = [
            [
                'name' => 'Ноутбук Asus',
                'category_id' => $cat1->id,
                'price' => 5555.50,
                'sale' => 12,
                'description' => 'Расположенная на Тайване транснациональная компания, специализирующаяся на компьютерной электронике. Название торговой марки Asus происходит от слова Pegasus.',
                'is_new' => true,
                'is_top_selling' => true,

            ],
            [
                'name' => 'Ноутбук Samsung',
                'category_id' => $cat1->id,
                'price' => 235346,
                'sale' => 32,
                'description' => 'Транснациональная компания по производству электроники, полупроводников, телекоммуникационного оборудования, чипов памяти, жидкокристаллических дисплеев, мобильных телефонов и мониторов.',
                'is_new' => false,
                'is_top_selling' => false,
            ],
            [
                'name' => 'Ноутбук Dell',
                'category_id' => $cat1->id,
                'price' => 67954,
                'sale' => 10,
                'description' => 'Американская корпорация, одна из крупнейших компаний в области производства компьютеров. Входила в список Fortune 1000, акции торговались на бирже NASDAQ, с 2013 года - частная компания. Штаб-квартира находится в Раунд-Роке в штате Техас в США.',
                'is_new' => true,
                'is_top_selling' => false,
            ],
            [
                'name' => 'Ноутбук Lenovo',
                'category_id' => $cat1->id,
                'price' => 65500,
                'sale' => 22,
                'description' => 'Китайская транснациональная корпорация, выпускающая персональные компьютеры и другую электронику. Является крупнейшим производителем персональных компьютеров в мире с долей на рынке более 20%, а также занимает пятое место по производству мобильных телефонов.',
                'is_new' => false,
                'is_top_selling' => true,
            ],
            [
                'name' => 'Ноутбук Apple',
                'category_id' => $cat1->id,
                'price' => 12345,
                'sale' => 10,
                'description' => 'Американская корпорация, производитель персональных и планшетных компьютеров, аудиоплееров, смартфонов, программного обеспечения. Один из пионеров в области персональных компьютеров и современных многозадачных операционных систем с графическим интерфейсом. ',
                'is_new' => true,
                'is_top_selling' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
