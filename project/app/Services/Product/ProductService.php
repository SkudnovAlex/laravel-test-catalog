<?php


namespace App\Services\Product;


use App\DbAccess\CategoryRepository;
use App\DbAccess\ProductRepository;
use App\DTO\Product\ProductListModel;
use App\DTO\Product\ProductModel;
use App\DTO\Response\ProductListResponseModel;
use App\Mapper\Mapper;
use App\Models\PagingModel;

class ProductService
{

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function create(ProductModel $model): int
    {
        return $this->productRepository->create($model);
    }

    public function delete(int $id): void
    {
        $this->productRepository->deleteById($id);
        //more action, notifications etc.
    }

    public function update(ProductModel $model):void
    {
        $this->productRepository->update($model);
    }

    public function getList(ProductListModel $model):PagingModel
    {
        $products = $this->productRepository->getByCategoryId($model->categoryId, $model->page, $model->pageSize);
        if (empty($products)) {
            return new PagingModel(0, []);
        }

        $total = $this->productRepository->total($model->categoryId);

        return new PagingModel($total, $products);
    }

    public function getListByCategoryCode(string $categoryCode, int $page = 1, $pageSize = 20): ?array
    {
        $categoryId = $this->categoryRepository->getByCode($categoryCode);
        if ($categoryId !== null) {
            return $this->productRepository->getByCategoryId($categoryId, $page, $pageSize);
        }

        return null;
    }

    public function getById(int $id)
    {
        $product = $this->productRepository->getById($id);

        return Mapper::from($product)->mapTo(new ProductListResponseModel());
    }
}
