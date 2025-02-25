<?php
namespace App\Filament;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;

// Form inputs for maximum by value.
class ByValueForm
{
    public static function schema(): array
    {
        return [
            // Section: Loan Calculation Details
            Section::make('Loan Calculation Details')
                ->description('Provide the details related to the loan calculation.')
                ->schema([

                    Grid::make(2)->schema([
                        TextInput::make('objectvalue')
                            ->label('Value of the Object / House')
                            ->numeric()
                            ->required()
                            ->prefixIcon('heroicon-o-home'),
                        
                        TextInput::make('duration')
                            ->label('Loan Duration (Months)')
                            ->numeric()
                            ->default(360)
                            ->required()
                            ->prefixIcon('heroicon-o-clock'),
                    ]),

                    Grid::make(2)->schema([
                        Toggle::make('onlyUseIncludedLabels')
                            ->label('Only Use Included Labels')
                            ->columnSpanFull()
                            ->default(false),

                        TextInput::make('not_deductible')
                            ->label('Not Deductible Part of Loan (Months)')
                            ->numeric()
                            ->default(0)
                            ->columnSpanFull()
                            ->prefixIcon('heroicon-o-currency-dollar'),
                    ]),
                ]),
        ];
    }
}
