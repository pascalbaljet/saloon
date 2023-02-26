<?php

declare(strict_types=1);

namespace Saloon\Tests\Fixtures\Connectors;

use ReturnTypeWillChange;
use Saloon\Contracts\Response;
use Saloon\Http\Connector;
use Saloon\Tests\Fixtures\Requests\UserRequest;
use Saloon\Tests\Fixtures\Responses\CustomResponse;
use Saloon\Traits\Plugins\AcceptsJson;

class TestConnector extends Connector
{
    use AcceptsJson;

    public bool $unique = false;

    /**
     * Define the base url of the api.
     *
     * @return string
     */
    public function resolveBaseUrl(): string
    {
        return apiUrl();
    }

    /**
     * Define the base headers that will be applied in every request.
     *
     * @return string[]
     */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
        ];
    }
}
