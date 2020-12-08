<?php

declare(strict_types=1);

namespace App\Infrastructure\Exception;

use App\Infrastructure\View\Error;
use Symfony\Component\HttpFoundation\Response;
use Violines\RestBundle\Error\ErrorInterface;

class NotFoundException extends \LogicException implements \Throwable, ErrorInterface
{
    public static function resource(): self
    {
        return new self('The requested resource was not found');
    }

    public function getContent(): object
    {
        return Error::create($this->message);
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
