<?php

namespace Tests\Feature;

use App\Saloon\Connectors\MortageConnector;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Tests\TestCase;
use App\Saloon\Requests\MortageByValueRequest;

class CalculateByValueComponentTest  extends TestCase
{
    /** @test */
    public function it_sends_requests()
    {
        // Mock the Saloon Client.
        $requestClass = MortageByValueRequest::class;
        $mockClient = new MockClient([
            $requestClass => MockResponse::make()
        ]);

        // Mock Connector.
        $connector = new MortageConnector();
        $connector->withMockClient($mockClient);

        // Mock request and send.
        $connector->send(new $requestClass($this->validFormData(), ''));

        // Assert send request.
        $mockClient->assertSent($requestClass);   
        $mockClient->assertSentCount(1);   
    }

    /**
     * Get valid form data for testing.
     *
     * @return array
     */
    protected function validFormData(): array
    {
        return [
            'objectvalue' => 250000,
            'duration' => 360,
            'not_deductible' => 0,
            'onlyUseIncludedLabels' => false,
        ];
    }
}
