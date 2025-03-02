<?php
namespace App\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Saloon\Connectors\MortageConnector;
use App\Saloon\Requests\MortageByIncomeRequest;
use Illuminate\Support\Facades\Log;
use App\Filament\ByIncomeForm;

class CalculateByIncomeComponent extends Component implements HasForms
{
    use InteractsWithForms;

    // Personal API key, Would save this in db in real work.
    public string $apiKey;

    // Form data that will be send to API.
    public array $incomeData;

    // Result vars.
    public string $maxMortgage;
    public string $totalReferenceIncome;
    public string $firstGrossPayment;

    public function mount() {
        $this->apiKey = env('API_KEY');

        // Prefilled form data for easier assesment testing.
        $this->form->fill([
            'calculation_date' => '2025-02-24',
            'nhg' => true,
            'duration' => 360,
            'percentage' => 1.501, // Specific Percentage requested.
            'rate_fixation' => 10,
            'not_deductible' => 0,
            'ground_rent' => 0,
            'energy_label' => 'A++++',
            'person' => [
                [
                    'income' => 50000,
                    'date_of_birth' => '1990-01-01',
                    'alimony' => 0,
                    'loans' => 10000,
                    'student_loan_monthly_amount' => 200,
                    'student_loan_start_date' => '2015-09-01',
                    'private_lease_amounts' => [100]
                ],
                [
                    'income' => 40000,
                    'date_of_birth' => '1992-03-15',
                    'alimony' => 0,
                    'loans' => 5000,
                    'student_loan_monthly_amount' => 150,
                    'student_loan_start_date' => '2016-10-01',
                    'private_lease_amounts' => [150]
                ],
            ],
        ]);

        // Force submit on pageload. 
        $this->submit();
    }

    // This form will be renderd inside the blade, Called like this: {{ $this->form }}.
    public static function form(Form $form): Form
    {
        return $form
            // Statepath makes sure the form uses that variable to store/read data.
            ->statePath('incomeData')
            // Schema returns actual inputs.
            ->schema(ByIncomeForm::schema());
    }

    // Sends the form input data to the API after validating first.
    public function submit()
    {
        // Validates form. Displays error if requirements are not met.
        $this->form->getState();

        // Convert boolean to string to prevent API errors.
        $validatedData = $this->incomeData;
        $validatedData['nhg'] = ($validatedData['nhg'] === 0) ? 'false' : 'true';

        try {
            // API request setup using Saloon.
            $connector = new MortageConnector();
            $response = $connector->send(new MortageByIncomeRequest($validatedData, $this->apiKey));

            // Read API response
            $data = json_decode($response->body(), true);
            if (! isset($data['data'])) {
                throw new \Exception('Invalid API response.');
            }

            $this->processResponseData($data);

          // Handle any potential errors.
        } catch (\Throwable $e) {
            Log::error('API request failed', [
                'message' => $e->getMessage(),
                'incomeData' => $this->incomeData,
                'trace' => $e->getTraceAsString(),
            ]);

            $this->addError('api', 'Failed to retrieve data from the API. Please try again later.');
        }
    }

    // Extract the necessary data from the response
    private function processResponseData($data) {
        $this->maxMortgage = $data['data']['result'];
        $this->firstGrossPayment = $data['data']['calculationValues']['firstGrossPayment'];
        $this->totalReferenceIncome = $data['data']['calculationValues']['totalReferenceIncome'];
    }

    // Renders the blade file.
    public function render()
    {
        return view('livewire.calculate-results');
    }
}
