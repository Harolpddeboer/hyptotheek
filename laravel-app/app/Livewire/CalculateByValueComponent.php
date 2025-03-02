<?php
namespace App\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Saloon\Connectors\MortageConnector;
use App\Saloon\Requests\MortageByValueRequest;
use Illuminate\Support\Facades\Log;
use App\Filament\ByValueForm;

class CalculateByValueComponent extends Component implements HasForms
{
    use InteractsWithForms;

    // Personal API key, Would save this in db in real work.
    public string $apiKey;

    // Form data that will be send to API.
    public array $incomeData;

    // Result vars.
    public string $maxMortgage;
    public string $firstGrossPayment;
    public string $interestRate;

    public function mount() {
        $this->apiKey = env('API_KEY');

        // Prefilled form data for easier assesment testing.
        $this->form->fill([
            'objectvalue' => 250000,
            'duration' => 360,
            'not_deductible' => 0,
            'onlyUseIncludedLabels' => false,
        ]);
    }

    // This form will be renderd inside the blade, Called like this: {{ $this->form }}.
    public static function form(Form $form): Form
    {
        return $form
            // Statepath makes sure the form uses that variable to store/read data.
            ->statePath('incomeData')
            // Schema returns actual inputs.
            ->schema(ByValueForm::schema());
    }

    // Sends the form input data to the API after validating first.
    public function submit()
    {
        // Validates form. Displays error if requirements are not met.
        $this->form->getState();

        // Convert boolean to string to prevent API errors.
        $validatedData = $this->incomeData;
        $validatedData['onlyUseIncludedLabels'] = ($validatedData['onlyUseIncludedLabels'] === 0) ? 'false' : 'true';

        try {
            // API request setup using Saloon.
            $connector = new MortageConnector();
            $response = $connector->send(new MortageByValueRequest($validatedData, $this->apiKey));
            
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
        $this->interestRate = $data['data']['calculationValues']['interestRate'];
    }

    // Renders the blade file.
    public function render()
    {
        return view('livewire.calculate-results');
    }
}
