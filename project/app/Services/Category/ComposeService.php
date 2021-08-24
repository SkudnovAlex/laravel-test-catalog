<?php


namespace App\Services\Category;

use App\DbAccess\CategoryRepository;
use App\DbAccess\ProductRepository;
use Illuminate\View\View;

class ComposeService
{
    /**
     * @var CategoryRepository
     */
    private CategoryRepository $categoryRepository;
    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    public function compose(View $view)
    {
        $view->with([
            'allCategories' => $this->categoryRepository->getAll(),
            'topCategories' => $this->categoryRepository->getTopList(),
            'topProducts' => $this->productRepository->getTopList(),
            'newProducts' => $this->productRepository->getNewList(),
        ]);
    }

}
