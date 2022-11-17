<?php declare(strict_types=1);

namespace Saloon\Http\Responses;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Saloon\Repositories\ArrayStore;
use Saloon\Traits\Macroable;
use Saloon\Traits\Responses\HasResponseHelpers;
use Saloon\Http\Request;
use Saloon\Http\PendingRequest;
use Saloon\Contracts\Response as ResponseContract;
use Throwable;

class Response implements ResponseContract
{
    use Macroable;
    use HasResponseHelpers;

    /**
     * The decoded JSON response.
     *
     * @var array
     */
    protected array $decodedJson;

    /**
     * The decoded XML response.
     *
     * @var string
     */
    protected string $decodedXml;

    /**
     * The request options we attached to the request.
     *
     * @var PendingRequest
     */
    protected PendingRequest $pendingSaloonRequest;

    /**
     * The raw PSR response from the sender.
     *
     * @var ResponseInterface|mixed
     */
    protected ResponseInterface $rawResponse;

    /**
     * The original request exception
     *
     * @var Throwable|null
     */
    protected ?Throwable $requestException = null;

    /**
     * Create a new response instance.
     *
     * @param PendingRequest $pendingSaloonRequest
     * @param ResponseInterface $rawResponse
     * @param Throwable|null $requestException
     */
    public function __construct(PendingRequest $pendingSaloonRequest, ResponseInterface $rawResponse, Throwable $requestException = null)
    {
        $this->pendingSaloonRequest = $pendingSaloonRequest;
        $this->rawResponse = $rawResponse;
        $this->requestException = $requestException;
    }

    /**
     * @return PendingRequest
     */
    public function getPendingRequest(): PendingRequest
    {
        return $this->pendingSaloonRequest;
    }

    /**
     * Get the original request
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->pendingSaloonRequest->getRequest();
    }

    /**
     * Get the original request exception
     *
     * @return Throwable|null
     */
    public function getRequestException(): ?Throwable
    {
        return $this->requestException;
    }

    /**
     * Get the raw response
     *
     * @return mixed
     */
    public function getRawResponse(): mixed
    {
        return $this->rawResponse;
    }

    /**
     * Check if the response has been cached
     *
     * @return bool
     */
    public function isCached(): bool
    {
        return false;
    }

    /**
     * Check if the response has been mocked
     *
     * @return bool
     */
    public function isMocked(): bool
    {
        return false;
    }

    /**
     * Get the body of the response as string.
     *
     * @return string
     */
    public function body(): string
    {
        return (string)$this->stream();
    }

    /**
     * Get the body as a stream. Don't forget to close the stream after using ->close().
     *
     * @return StreamInterface
     */
    public function stream(): StreamInterface
    {
        return $this->rawResponse->getBody();
    }

    /**
     * Get the headers from the response.
     *
     * @return ArrayStore
     */
    public function headers(): ArrayStore
    {
        return new ArrayStore($this->rawResponse->getHeaders());
    }

    /**
     * Get the status code of the response.
     *
     * @return int
     */
    public function status(): int
    {
        return $this->rawResponse->getStatusCode();
    }

    /**
     * Create a PSR response from the raw response.
     *
     * @return ResponseInterface
     */
    public function getPsrResponse(): ResponseInterface
    {
        return $this->rawResponse;
    }
}
