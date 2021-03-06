<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Infrastructure\Exception\NotFoundException;
use App\Domain\Catalog\Query\FilterProducts;
use App\Domain\Catalog\Exception\ProductNotExists;
use App\Domain\Catalog\ProductService;
use App\Domain\Catalog\Query\FilterCategories;
use App\Domain\Catalog\Value\Language;
use App\Domain\Catalog\Value\ProductId;
use App\Domain\Catalog\View\ProductDetail;
use App\Infrastructure\QueryBus\QueryBus;
use Symfony\Component\Routing\Annotation\Route;

class ProductController
{
    private ProductService $productService;
    private QueryBus $queryBus;

    public function __construct(ProductService $productService, QueryBus $queryBus)
    {
        $this->productService = $productService;
        $this->queryBus = $queryBus;
    }

    #[Route('/{_locale}/categories', methods: ['GET'], name: 'frontend_categories', requirements: ['_locale' => 'en|de'])]
    public function findCategories(string $_locale): array
    {
        $filterCategories = new FilterCategories();
        $filterCategories->language = $_locale;

        return $this->queryBus->query($filterCategories);
    }

    #[Route('/{_locale}/products', methods: ['GET'], name: 'frontend_products', requirements: ['_locale' => 'en|de'])]
    public function findProducts(FilterProducts $filterProducts, string $_locale): array
    {
        $filterProducts->language = $_locale;

        return $this->queryBus->query($filterProducts);
    }

    #[Route('/{_locale}/product/{id}', methods: ['GET'], name: 'frontend_product', requirements: ['_locale' => 'en|de'])]
    public function findProduct(int $id, string $_locale): ProductDetail
    {
        try {
            $product = $this->productService->findProduct(ProductId::fromInt($id), Language::fromString($_locale));
        } catch (ProductNotExists $e) {
            throw NotFoundException::resource();
        }

        return $product;
    }
}
