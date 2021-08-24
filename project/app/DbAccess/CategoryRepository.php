<?php declare(strict_types=1);

namespace App\DbAccess;

use App\DbModels\Category;
use App\DTO\Category\CategoryModel;
use App\Mapper\Mapper;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function getTopList(): ?Collection
    {
        return Category::query()->where('parent', '=', 0)
            ->orderBy('sort')
            ->get();
    }

    public function getAll(): ?Collection
    {
        return Category::query()
            ->orderBy('sort')
            ->get();
    }

    public function getListByCode(string $category): ?Collection
    {
        $parentId = $this->getByCode($category);
        if ($parentId !== null) {
            return Category::query()->where('parent', $parentId)
                ->get();
        }

        return null;
    }

    public function getByCode(string $code): ?int
    {
        $category = Category::query()->where('code', $code)
            ->get()
            ->first();
        if ($category) {
            return $category->id;
        }

        return null;
    }

    public function create(CategoryModel $model): int
    {
        /** @var Category $entity */
        $entity = Mapper::from($model)->mapTo(new Category());
        $entity->save();

        return $entity->id;
    }

    public function createIfNotExist(CategoryModel $model): int
    {
        $categoryId = $this->getByCode($model->code);
        if ($categoryId === null) {
            $categoryId = $this->create($model);
        }

        return $categoryId;
    }
}
