<?php
namespace App\Filament;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Select;

// Form inputs for maximum by income.
class ByIncomeForm
{
    public static function schema(): array
    {
    // Options for the energy label select.
    $energyLabels = ['A++++ WITH ENERGY PERFORMANCE GUARANTEE', 'A++++', 'A+++', 'A++', 'A+', 'A', 'B', 'C', 'D', 'E', 'F', 'G'];

    return [
            // Section: Calculation Details
            Section::make('Calculation Details')
                ->description('Provide details related to the mortgage calculation.')
                ->schema([
                    Grid::make(1)->schema([
                        Toggle::make('nhg')
                            ->label('NHG (Nationale Hypotheek Garantie)')
                            ->columnSpanFull(),

                        DatePicker::make('calculation_date')
                            ->label('Calculation Date')    
                            ->prefixIcon('heroicon-o-calendar'),
                    ]),

                    Grid::make(2)->schema([
                        TextInput::make('duration')
                            ->label('Mortgage Duration (Months)')
                            ->numeric()
                            ->prefixIcon('heroicon-o-clock'),
                    
                        TextInput::make('percentage')
                            ->label('Interest Percentage')
                            ->numeric()
                            ->required()
                            ->prefixIcon('heroicon-o-calculator'),
                    ]),

                    Grid::make(2)->schema([
                        TextInput::make('rate_fixation')
                            ->label('Rate Fixation Period (Years)')
                            ->numeric()
                            ->prefixIcon('heroicon-o-clock'),
                    
                        TextInput::make('not_deductible')
                            ->label('Non-deductible Amount')
                            ->numeric()
                            ->prefixIcon('heroicon-o-currency-dollar'),
                    ]),

                    Grid::make(2)->schema([
                        TextInput::make('ground_rent')
                            ->label('Ground Rent (Per Year)')
                            ->numeric()
                            ->prefixIcon('heroicon-o-home'),
                    
                        Select::make('energy_label')
                            ->label('Energy Label')
                            ->options(array_combine($energyLabels, $energyLabels))
                            ->selectablePlaceholder(false)
                            ->required()
                            ->prefixIcon('heroicon-o-tag')
                    ]),
                ]), 

            // Section: Person 1 Details
            Section::make('Person 1 Details')
                ->description('Enter the details of the first person.')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('person.0.income')
                            ->label('Income for Person 1')
                            ->numeric()
                            ->prefix('€')
                            ->required()
                            ->prefixIcon('heroicon-o-currency-dollar'),
                    
                        DatePicker::make('person.0.date_of_birth')
                            ->label('Date of Birth for Person 1')
                            ->prefixIcon('heroicon-o-calendar'),
                    ]),

                    Grid::make(2)->schema([
                        TextInput::make('person.0.alimony')
                            ->label('Alimony for Person 1')
                            ->numeric()
                            ->prefixIcon('heroicon-o-user'),
                    
                        TextInput::make('person.0.loans')
                            ->label('Loans for Person 1')
                            ->numeric()
                            ->prefixIcon('heroicon-o-credit-card'),
                    ]),

                    Grid::make(2)->schema([
                        TextInput::make('person.0.student_loan_monthly_amount')
                            ->label('Student Loan Monthly Amount for Person 1')
                            ->numeric()
                            ->prefixIcon('heroicon-o-currency-dollar'),
                    
                        DatePicker::make('person.0.student_loan_start_date')
                            ->label('Student Loan Start Date for Person 1')
                            ->prefixIcon('heroicon-o-calendar'),
                    ]),

                    TagsInput::make('person.0.private_lease_amounts')
                        ->label('Private Lease Amounts for Person 1')
                        ->placeholder('Enter lease amounts')
                        ->required()
                        ->prefixIcon('heroicon-o-tag'),
                ]), 

            // Section: Person 2 Details
            Section::make('Person 2 Details')
                ->description('Enter the details of the second person.')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('person.1.income')
                            ->label('Income for Person 2')
                            ->numeric()
                            ->prefix('€')
                            ->prefixIcon('heroicon-o-currency-dollar'),
                    
                        DatePicker::make('person.1.date_of_birth')
                            ->label('Date of Birth for Person 2')
                            ->prefixIcon('heroicon-o-calendar'),
                    ]),

                    Grid::make(2)->schema([
                        TextInput::make('person.1.alimony')
                            ->label('Alimony for Person 2')
                            ->numeric()
                            ->prefixIcon('heroicon-o-user'),
                    
                        TextInput::make('person.1.loans')
                            ->label('Loans for Person 2')
                            ->numeric()
                            ->prefixIcon('heroicon-o-credit-card'),
                    ]),
                    
                    Grid::make(2)->schema([
                        TextInput::make('person.1.student_loan_monthly_amount')
                            ->label('Student Loan Monthly Amount for Person 2')
                            ->numeric()
                            ->prefixIcon('heroicon-o-currency-dollar'),
                    
                        DatePicker::make('person.1.student_loan_start_date')
                            ->label('Student Loan Start Date for Person 2')
                            ->prefixIcon('heroicon-o-calendar'),
                    ]),

                    TagsInput::make('person.1.private_lease_amounts')
                        ->label('Private Lease Amounts for Person 2')
                        ->placeholder('Enter lease amounts')
                        ->prefixIcon('heroicon-o-tag'),
                ]),
        ];
    }
}
