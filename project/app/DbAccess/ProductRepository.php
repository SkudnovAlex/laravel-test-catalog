<?php declare(strict_types=1);

namespace App\DbAccess;

use App\DbModels\Product;
use App\DTO\Product\ProductModel;
use App\DTO\Response\ProductListResponseModel;
use App\Mapper\Mapper;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function create(ProductModel $model): int
    {
        /** @var Product $entity */
        $entity = Mapper::from($model)->mapTo(new Product());
        $entity->save();

        return $entity->id;
    }


    public function deleteById(int $id):void
    {
        Product::destroy($id);
    }

    public function update(ProductModel $model):void
    {
        $entity = Mapper::from($model)->exclude(['id'])->mapTo(new Product());
        Product::query()->where('id', $model->id)->update(
            $entity->toArray()
        );
    }

    public function isExistById(int $id): bool
    {
        return Product::query()->where('id', $id)->exists();
    }

    public function getByCategoryId(int $categoryId, int $page, int $pageSize): array
    {
        return Product::query()->where('category_id', $categoryId)
            ->orderByDesc('id')
            ->offset(($page - 1) * $pageSize)
            ->limit($pageSize)
            ->get()
            ->map(function (Product $item) {
                Mapper::from($item)->mapTo(new ProductListResponseModel());
                $item->salePrice = $item->price - ($item->price * $item->sale / 100);

                return $item;
            })
            ->all();
    }

    public function getById(int $id): ?Product
    {
        return Product::query()->find($id);
    }

    public function total(?int $categoryId = null): int
    {
        $request = Product::query();
        if ($categoryId !== null) {
            return $request->where('category_id', '=', $categoryId)
                ->count();
        }

        return $request->count();
    }

    public function getTopList(): ?Collection
    {
        return Product::query()->where('is_top_selling', true)
            ->get();
    }

    public function getNewList(): ?Collection
    {
        return Product::query()->where('is_new', true)
            ->get();
    }
}
