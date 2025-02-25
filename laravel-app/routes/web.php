<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CalculateByIncomeComponent;
use App\Livewire\CalculateByValueComponent;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/calculate-by-income', CalculateByIncomeComponent::class);
Route::get('/calculate-by-value', CalculateByValueComponent::class);
