<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Domain\Product\Exception\ProductNotExists;
use App\Domain\Product\Repository\ProductDetailRepository;
use App\Domain\Product\Value\Language;
use App\Domain\Product\Value\ProductId;
use App\Domain\Product\View\ProductDetail;

class ProductService
{
    public function __construct(private ProductDetailRepository $productDetailRepository)
    {
    }

    public function findProduct(ProductId $productId, Language $language): ProductDetail
    {
        try {
            return $this->productDetailRepository->find($productId)->withLanguage($language);
        } catch (\Throwable $e) {
            throw ProductNotExists::id($productId->toInt());
        }
    }
}
