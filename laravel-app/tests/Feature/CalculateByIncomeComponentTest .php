<?php

namespace Tests\Feature;

use App\Saloon\Connectors\MortageConnector;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Tests\TestCase;
use App\Saloon\Requests\MortageByIncomeRequest;

class CalculateByIncomeComponentTest  extends TestCase
{
    /** @test */
    public function it_sends_requests()
    {
        // Mock the Saloon Client.
        $requestClass = MortageByIncomeRequest::class;
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
            'calculation_date' => '2025-02-24',
            'nhg' => 'false',
            'duration' => 360,
            'percentage' => 3.5,
            'rate_fixation' => 10,
            'not_deductible' => 0,
            'ground_rent' => 0,
            'energy_label' => 'E',
            'person' => [
                [
                    'income' => 50000,
                    'date_of_birth' => '1990-01-01',
                    'alimony' => 0,
                    'loans' => 10000,
                    'student_loan_monthly_amount' => 200,
                    'student_loan_start_date' => '2015-09-01',
                    'private_lease_amounts' => [100],
                ],
                [
                    'income' => 40000,
                    'date_of_birth' => '1992-03-15',
                    'alimony' => 0,
                    'loans' => 5000,
                    'student_loan_monthly_amount' => 150,
                    'student_loan_start_date' => '2016-10-01',
                    'private_lease_amounts' => [150],
                ],
            ],
        ];
    }
}
