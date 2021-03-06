<?php

namespace App\Domain\Catalog\Repository;

use App\Domain\Catalog\Product;
use App\Domain\Catalog\Value\Gtin;
use App\Domain\Catalog\Value\ProductId;

interface ProductRepository
{
    /**
     * @return ProductId
     */
    public function nextId(): ProductId;

    /**
     * @param Product $product
     */
    public function save(Product $product): void;

    /**
     * @param Gtin $gtin
     * @return bool
     */
    public function exists(Gtin $gtin): bool;

    /**
     * @param ProductId $productId
     * @return Product
     */
    public function find(ProductId $productId): Product;
}
