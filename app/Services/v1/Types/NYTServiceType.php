<?php

namespace App\Services\v1\Types;

class NYTServiceType
{
    public int $http_code;
    public array $json_data;

    public function __construct(array $json_data = [], int $http_code = 200)
    {
        $this->json_data = $json_data;
        $this->http_code = $http_code;
    }
}
