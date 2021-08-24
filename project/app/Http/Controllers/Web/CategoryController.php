<?php

namespace App\Http\Controllers\Web;

use App\DbAccess\CategoryRepository;
use App\Http\Controllers\Controller;
use App\Services\Category\ComposeService;

class CategoryController extends Controller
{
    private ComposeService $categoryService;
    private CategoryRepository $categoryRepository;

    public function __construct(
        ComposeService $categoryService,
        CategoryRepository $categoryRepository
    ) {
        $this->categoryService = $categoryService;
        $this->categoryRepository = $categoryRepository;
    }

    public function listCategories(string $category)
    {
        return view('shop.listCategories', [
            'subCategory' => $this->categoryRepository->getListByCode($category),
        ]);
    }
}
