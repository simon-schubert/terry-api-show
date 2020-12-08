<?php

declare(strict_types=1);

namespace App\User\View;

use Symfony\Component\Serializer;
use Violines\RestBundle\HttpApi\HttpApi;

/**
 * @HttpApi
 */
final class ProfileView
{
    /**
     * @Serializer\Annotation\SerializedName("user_id")
     */
    private int $userId;

    private string $email;

    private ?string $key;

    public function __construct(
        int $userId,
        string $email,
        ?string $key = null
    ) {
        $this->userId = $userId;
        $this->email = $email;
        $this->key = $key;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }
}
