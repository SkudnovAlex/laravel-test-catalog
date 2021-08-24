<?php

namespace Tests;

use App\DbModels\Product;
use App\Models\OperationResultStatus;


class ProductTest extends TestCase
{
    public function testShouldCreateProduct()
    {
        $this->put('/api/product', [
            'name' => 'book',
            'categoryId' => 12,
            'price' => rand(1, 1000),
            'description' => 'description of product'
        ])
            ->assertJsonFragment([
            'message' => trans('product.created'),
            'status' => OperationResultStatus::SUCCESS
        ]);
    }

    public function testShouldDeleteteProduct()
    {
        $product = Product::factory(['category_id' => 36])->create();
        $response = $this->delete('/api/product', [
            'id' => $product->id
        ]);

        $this->assertFalse(Product::query()->where('id', $product->id)->exists());
        $response->assertJsonFragment([
            'message' => trans('product.deleted'),
            'status' => OperationResultStatus::SUCCESS
        ]);
    }

    public function testShouldUpdateProduct()
    {
        $product = Product::factory(['category_id' => 77])->create();
        $response = $this->post('/api/product/update', [
            'id' => $product->id,
            'name' => 'new Name of product'
        ]);
        $product->refresh();

        $this->assertEquals('new Name of product', $product->name);
        $response->assertJsonFragment([
            'message' => trans('product.updated'),
            'status' => OperationResultStatus::SUCCESS
        ]);
    }


    public function testNotShouldUpdateProductIfItNotExist()
    {
        $response = $this->post('/api/product/update', [
            'id' => 987987,
            'name' => 'new Name of product'
        ]);

        $response->assertJsonFragment([
            'message' => trans('product.notFound'),
            'status' => OperationResultStatus::SUCCESS
        ]);
    }

    public function testShouldReturnProductById()
    {
        Product::query()->where('category_id', 781)->delete();
        $product = Product::factory(['category_id' => 781])->create();
        $this->get("/api/product/$product->id")
            ->assertJson([
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'categoryId' => $product->category_id,
                'price' => $product->price,
                'description' => $product->description,
            ],
            'status' => OperationResultStatus::SUCCESS
        ]);
    }

    public function testNotShouldReturnProductByIdIfItNotExist()
    {
        $this->get("/api/product/987987987")
            ->assertJsonFragment([
                'message' => trans('product.notFound'),
                'status' => OperationResultStatus::SUCCESS
            ]);
    }

    public function testShouldReturnListProduct()
    {
        Product::query()->where('category_id', 999)->delete();
        $product1 = Product::factory(['category_id' => 999])->create();
        $product2 = Product::factory(['category_id' => 999])->create();
        $product3 = Product::factory(['category_id' => 999])->create();

        $this->post('/api/product/list', [
            'categoryId' => 999,
        ])
            ->assertJson([
            'status' => OperationResultStatus::SUCCESS,
            'data' => [
                'total' => 3,
                'data' => [
                    [
                        'id' => $product3->id,
                        'name' => $product3->name,
                        'categoryId' => $product3->category_id,
                        'price' => $product3->price,
                        'description' => $product3->description,
                    ],
                    [
                        'id' => $product2->id,
                        'name' => $product2->name,
                        'categoryId' => $product2->category_id,
                        'price' => $product2->price,
                        'description' => $product2->description,
                    ],
                    [
                        'id' => $product1->id,
                        'name' => $product1->name,
                        'categoryId' => $product1->category_id,
                        'price' => $product1->price,
                        'description' => $product1->description,
                    ],
                ]
            ],
        ]);
    }

    public function testShouldReturnListProductWithPages()
    {
        Product::query()->where('category_id', 888)->delete();
        $product1 = Product::factory(['category_id' => 888])->create();
        $product2 = Product::factory(['category_id' => 888])->create();
        $product3 = Product::factory(['category_id' => 888])->create();

        $this->post('/api/product/list', [
            'categoryId' => 888,
            'page' => 1,
            'pageSize' => 2,
        ])
            ->assertJson([
            'status' => OperationResultStatus::SUCCESS,
            'data' => [
                'total' => 3,
                'data' => [
                    [
                        'id' => $product3->id,
                        'name' => $product3->name,
                        'categoryId' => $product3->category_id,
                        'price' => $product3->price,
                        'description' => $product3->description,
                    ],
                    [
                        'id' => $product2->id,
                        'name' => $product2->name,
                        'categoryId' => $product2->category_id,
                        'price' => $product2->price,
                        'description' => $product2->description,
                    ],
                ]
            ],
        ]);
    }

    public function testShouldReturnEmptyListProduct()
    {
        $this->post('/api/product/list', [
            'categoryId' => 123123,
        ])
            ->assertJson([
            'status' => OperationResultStatus::SUCCESS,
            'data' => [
                'total' => 0,
                'data' => []
            ],
        ]);
    }
}
