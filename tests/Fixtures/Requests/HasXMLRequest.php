<?php declare(strict_types=1);

namespace Saloon\Tests\Fixtures\Requests;

use Saloon\Http\Request;
use Saloon\Traits\Body\HasXmlBody;
use Saloon\Contracts\Body\WithBody;
use Saloon\Tests\Fixtures\Connectors\TestConnector;

class HasXMLRequest extends Request implements WithBody
{
    use HasXmlBody;

    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected string $method = 'GET';

    /**
     * The connector.
     *
     * @var string|null
     */
    protected string $connector = TestConnector::class;

    /**
     * Define the endpoint for the request.
     *
     * @return string
     */
    public function defineEndpoint(): string
    {
        return '/user';
    }

    protected function defaultBody(): ?string
    {
        return '<xml></xml>';
    }
}
