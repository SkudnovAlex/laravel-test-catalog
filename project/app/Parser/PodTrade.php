<?php


namespace App\Parser;


use App\DbAccess\CategoryRepository;
use App\DbAccess\ProductRepository;
use App\DTO\Category\CategoryModel;
use App\DTO\Product\ProductModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;
use stringEncode\Exception;

class PodTrade extends Parser
{
    private string $baseUrl = 'https://podtrade.ru';
    private array $listLinks = [
        '/catalog/01_sharikovye_podshipniki/',
        '/catalog/02_rolikovye_podshipniki/',
    ];
    private string $categoryToCopy = 'bearing';
    private int $limitPages = 1;
    private array $listCategories = [];
    private array $listProducts = [];
    private int $parentCategories;

    private CategoryRepository $categoryRepository;
    private ProductRepository $productRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    protected function parseListCategories(): array
    {
        $dom = new Dom();
        $listCategories = [];
        foreach ($this->listLinks as $category) {
            $dom->loadFromUrl($this->baseUrl . $category)->outerHtml;

            foreach ($dom->find(".bx_catalog_tile_title") as $key => $value) {
                $name = $value->find('a')->text();
                $newCategory = new CategoryModel();
                $newCategory->parent = $this->parentCategories;
                $newCategory->name = $name;
                $newCategory->code = Str::slug($name, '-', 'ru');

                $listCategories[] = [
                    'id' => $this->categoryRepository->createIfNotExist($newCategory),
                    'href' => $value->find('a')->getAttribute('href'),
                ];
            }
        }

        return $listCategories;
    }

    protected function parseListProducts(): array
    {
        $dom = new Dom();
        $listProducts = [];
        foreach ($this->listCategories as $category) {
            $currentPage = 1;
            while ($this->limitPages >= $currentPage) {
                $dom->loadFromUrl($this->baseUrl . $category['href'] . '?PAGEN_1=' . $currentPage)->outerHtml;

                foreach ($dom->find(".block-view-title") as $value) {
                    $listProducts[$category['id']][] = $value->find('a')->getAttribute('href');
                }
                $currentPage++;
            }
        }
        return $listProducts;
    }

    protected function parseProducts(): void
    {
        $dom = new Dom();
        foreach ($this->listProducts as $categoryId => $linkPages) {
            foreach ($linkPages as $page) {
                $dom->loadFromUrl($this->baseUrl . $page)->outerHtml;

                $newProduct = new ProductModel();
                $newProduct->categoryId = $categoryId;
                $newProduct->name = $dom->find('h1[itemprop="name"]')[0]->text;
                $price = preg_replace('/\D+/', '', $dom->getElementsByClass('buy-price')[0]->text);
                $newProduct->price = $price ? (int)$price : 0;
                $newProduct->description = $dom->find('.detail-tabs-grid .tabs-item[data-tabsourcename="2"]')[0]->innerHtml;
                $this->productRepository->create($newProduct);
            }
        }
    }

    public function run(): string
    {
        try {
            DB::beginTransaction();
            $newCategory = new CategoryModel();
            $newCategory->parent = 0;
            $newCategory->name = 'Подшибники';
            $newCategory->code = $this->categoryToCopy;

            $this->parentCategories = $this->categoryRepository->createIfNotExist($newCategory);

            $this->listCategories = $this->parseListCategories();
            $this->listProducts = $this->parseListProducts();
            $this->parseProducts();
            DB::commit();

            return 'Parse has been finished success';
        } catch (Exception  $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
