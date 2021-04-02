<?php

namespace App\Tests\Controller;

use App\Tests\RestTestCase;

class ReviewControllerTest extends RestTestCase
{
    public function testCreateReview()
    {
        $headers = array_replace(self::DEFAULT_HEADERS, [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->getUserToken()
        ]);

        $this->client->request(
            'POST',
            'de/review/create',
            [],
            [],
            $headers,
            $this->reviewPayload
        );

        $this->assertResponseIsSuccessful();
    }

    private $reviewPayload = <<<'EOT'
    {
        "productId": 1,
        "gtin": "886037363214",
        "taste": 5,
        "ingredients": 4,
        "healthiness": 5,
        "packaging": 2,
        "availability": 1,
        "comment": "This is awesome."
    }
    EOT;
}