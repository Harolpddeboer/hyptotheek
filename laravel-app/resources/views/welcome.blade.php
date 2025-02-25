<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet" />

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    
        @livewireStyles
        @filamentStyles
  </head>

  <body>
        @livewireScripts
        @filamentScripts

        @yield('content')

        {{-- Manual buttons instead of routes for the separate components, Routes exist but they don't work for me. --}}
        <div class="flex justify-center min-h-screen bg-gray-300">
            <div class="w-full sm:w-3/4 md:w-2/3 lg:w-4/6 my-10 mx-auto bg-white p-10 rounded-lg shadow-md relative">
                <div x-data="{ activeTab: 1 }">
                    <!-- Tab Buttons Container -->
                    <div class="absolute top-0 left-0 right-0 p-4 z-10 flex justify-center space-x-4 mb-4">
                        <button :class="{'text-white bg-orange-500': activeTab === 1, 'text-gray-700': activeTab !== 1}" 
                                @click="activeTab = 1" class="font-semibold px-4 py-2 rounded-lg shadow-md border border-gray-300">
                            By Income
                        </button>

                        <button :class="{'text-white bg-orange-500': activeTab === 2, 'text-gray-700': activeTab !== 2}" 
                                @click="activeTab = 2" class="font-semibold px-4 py-2 rounded-lg shadow-md border border-gray-300">
                            By Value
                        </button>
                    </div>

                    <!-- Tab Content -->
                    <div class="pt-16">
                        <div x-show="activeTab === 1">
                            <livewire:calculate-by-income-component />
                        </div>

                        <div x-show="activeTab === 2">
                            <livewire:calculate-by-value-component />
                        </div>
                    </div>
                </div>
            </div>
        </div>
  </body>
</html>