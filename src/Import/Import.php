<?php

declare(strict_types=1);

namespace App\Import;

use App\Import\Model\Candy;
use App\Import\Model\Review;
use App\Repository\CandyRepository;
use App\Repository\ReviewRepository;

class Import
{
    private CandyRepository $candyRepository;

    private ReviewRepository $reviewRepository;

    public function __construct(
        CandyRepository $candyRepository,
        ReviewRepository $reviewRepository
    ) {
        $this->candyRepository = $candyRepository;
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * @param Candy[] $candies
     */
    public function candies(array $candies): void
    {
        $this->candyRepository->insert($candies);
    }

    /**
     * @param Review[] $candies
     */
    public function reviews(array $reviews): void
    {
        $this->reviewRepository->insert($reviews);
    }
}