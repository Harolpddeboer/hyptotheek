<?php

namespace App\Saloon\Connectors;

use Saloon\Http\Connector;

class MortageConnector extends Connector
{
    public function resolveBaseUrl(): string
    {
        return 'https://api.hypotheekbond.nl';
    }
}