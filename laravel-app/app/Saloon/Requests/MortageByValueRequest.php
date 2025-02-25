<?php

namespace App\Saloon\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class MortageByValueRequest extends Request
{
    protected Method $method = Method::GET;
    
    public function __construct(
        protected array $data,
        protected string $apiKey
    ){}

    public function resolveEndpoint(): string
    {
        return '/calculation/v1/mortgage/maximum-by-value?api_key=' . $this->apiKey;
    }
    
    // Sends $incomeData as query to the api.
    protected function defaultQuery(): array
    {
        return $this->data;
    }
}
