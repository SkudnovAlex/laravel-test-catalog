<?php

namespace App\Http\Controllers\Api;

use App\DbAccess\ProductRepository;
use App\DTO\Product\ProductListModel;
use App\DTO\Product\ProductModel;
use App\Http\RequestForms\Product\ProductCreateRequestForm;
use App\Http\RequestForms\Product\ProductDeleteRequestForm;
use App\Http\RequestForms\Product\ProductListRequestForm;
use App\Http\RequestForms\Product\ProductUpdateRequestForm;
use App\Mapper\Mapper;
use App\Models\CreateResultModel;
use App\Services\Product\ProductService;
use Illuminate\Http\JsonResponse;

class ProductApiController extends BaseController
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

    public function create(ProductCreateRequestForm $request): JsonResponse
    {
        $data = $request->body();
        $model = Mapper::from($data)->mapTo(new ProductModel());

        $id = $this->productService->create($model);

        return $this->successResponse(new CreateResultModel($id), trans('product.created'));
    }

    public function delete(ProductDeleteRequestForm $request): JsonResponse
    {
        $data = $request->body();

        $this->productService->delete($data->id);

        return $this->successResponse(null, trans('product.deleted'));
    }


    public function update(ProductUpdateRequestForm $request): JsonResponse
    {
        $data = $request->body();
        $entityId = $data->id;

        if (!$this->productRepository->isExistById($entityId)) {
            return $this->successResponse(null, trans('product.notFound'));
        }
        $model = Mapper::from($data)->mapTo(new ProductModel());
        $this->productService->update($model);

        return $this->successResponse(new CreateResultModel($entityId), trans('product.updated'));
    }


    public function getListByCategoryId(ProductListRequestForm $request): JsonResponse
    {
        $data = $request->body();

        $model = Mapper::from($data)->mapTo(new ProductListModel());
        $result = $this->productService->getList($model);

        return $this->successResponse($result);
    }


    public function getById(int $id): JsonResponse
    {
        if (!$this->productRepository->isExistById($id)) {
            return $this->successResponse(null, trans('product.notFound'));
        }

        return $this->successResponse($this->productService->getById($id));
    }
}
