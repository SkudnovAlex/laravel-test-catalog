<?php

namespace App\Http\Controllers\Web;

use App\DbAccess\ProductRepository;
use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;

class ProductController extends Controller
{
    private ProductService $productService;
    private ProductRepository $productRepository;

    public function __construct(
        ProductService $productService,
        ProductRepository $productRepository
    ) {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }

    public function listProducts(string $codeCategory)
    {
        return view('shop.listProducts', [
            'productList' => $this->productService->getListByCategoryCode($codeCategory),
        ]);
    }


    public function getProduct(string $category, int $id)
    {
        return view('shop.product', [
            'product' => $this->productRepository->getById($id),
        ]);
    }
}
