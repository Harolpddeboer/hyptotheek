    <!-- Main container with responsive width -->
    <div>
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <!-- Title -->
            <div class="text-center text-3xl sm:text-4xl font-bold text-gray-800 mb-6">
                Mortgage Calculator
            </div>

            <!-- Description -->
            <div class="text-center text-md sm:text-lg font-medium text-gray-600 mb-10 pb-6">
                A tool to calculate the maximum mortgage based on income or property value using the provided API.
            </div>

            <!-- Dynamic Filament form content -->
            <div class="text-center text-2xl sm:text-3xl font-semibold text-gray-800 mt-10 mb-6">
                {{ $this->form }}
            </div>
        </div>

        <!-- Display max mortgage if available -->
        <div class="w-1/2">
            @if(isset($this->maxMortgage) && $this->maxMortgage)
                <div class="mt-8 p-6 bg-green-600 text-white rounded-lg shadow-lg">
                    <strong class="text-lg">Max Mortgage:</strong>
                    <span class="font-bold text-xl">€{{ number_format($this->maxMortgage, 2) }}</span>
                </div>
            @endif
    
            <!-- Display total reference income if available -->
            @if(isset( $this->totalReferenceIncome) && $this->totalReferenceIncome)
                <div class="mt-8 p-6 bg-blue-600 text-white rounded-lg shadow-lg">
                    <strong class="text-lg">Total Reference Income:</strong>
                    <span class="font-bold text-xl">€{{ number_format($this->totalReferenceIncome, 2) }}</span>
                </div>
            @endif
    
            <!-- Display first gross payment if available -->
            @if(isset($this->firstGrossPayment) && $this->firstGrossPayment)
                <div class="mt-8 p-6 bg-yellow-600 text-white rounded-lg shadow-lg">
                    <strong class="text-lg">First Gross Payment:</strong>
                    <span class="font-bold text-xl">€{{ number_format($this->firstGrossPayment, 2) }}</span>
                </div>
            @endif
    
            <!-- Display first gross payment if available -->
            @if(isset($this->interestRate) && $this->interestRate)
                <div class="mt-8 p-6 bg-yellow-600 text-white rounded-lg shadow-lg">
                    <strong class="text-lg">Interest Rate:</strong>
                    <span class="font-bold text-xl">€{{ number_format($this->interestRate, 2) }}</span>
                </div>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="mt-6 absolute bottom-6 right-6">
            <button type="button" 
                wire:click="submit" 
                class="bg-orange-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-600 transition duration-200 flex items-center justify-center space-x-2">
                <x-heroicon-o-paper-airplane class="w-5 h-5"/>
                <span>
                    Calculate
                </span>
            </button>
        </div>
    </div>

