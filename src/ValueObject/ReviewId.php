<?php

declare(strict_types=1);

namespace App\ValueObject;

use Webmozart\Assert\Assert;

final class ReviewId
{
    private int $reviewId;

    private function __construct(int $reviewId)
    {
        $this->reviewId = $reviewId;
    }

    public static function new(int $reviewId)
    {
        Assert::greaterThanEq($reviewId, 1, 'Value must be positive and not 0');

        return new self($reviewId);
    }

    public function toInt(): int
    {
        return $this->reviewId;
    }
}
