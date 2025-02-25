## Overview

This Laravel application is designed for handling the Hypotheek API, incorporating both front-end and back-end functionality. Saloon is used for API interactions, while Filament simplifies form management.

- **Laravel**: PHP framework for web application development.
- **Livewire**: A full-stack framework for Laravel that enables building dynamic, interactive interfaces using PHP instead of JavaScript.
- **Tailwind CSS**: Utility-first CSS framework for designing responsive and modern UI.
- **Laravel Mix**: Simplifies asset compilation and optimization.
- **Filament**: Admin panel package for rapid UI development.
- **Saloon**: HTTP request package for structured and customizable API requests.
- **MySQL**: Database server for storing application data.

## Requirements

Dependencies are managed automatically by Docker. Compatibility with macOS/Linux remains unverified. Tested on Windows 11.

- PHP >= 8.2
- Filament ^3.2
- Livewire 3.5
- Saloon 3.0
- Docker
- Composer
- Node.js
- NPM

## Installation

#### Clone the repository

```bash
git clone https://github.com/Harolpddeboer/hyptotheek.git
```

#### Docker setup

http://localhost:9000/ for the application.
http://localhost:9001/index.php?route=/ for phpmyadmin.

```bash
// Build the docker container
docker-compose build --no-cache --force-rm

// Run database migrations/seed
docker exec laravel-docker bash -c "php artisan migrate"
docker exec laravel-docker bash -c "php artisan db:seed"
```

phpmyadmin login:

```
Server: mmysql_db
Username: admin
Password: root

db: hypotheek
```

#### Compile CSS

```bash
cd laravel-app

npm run watch
```

### Code

#### API Requests

API request handling is done in:

```
laravel-app\app\Saloon\Requests\MortageByIncomeRequest.php
laravel-app\app\Saloon\Requests\MortageByValueRequest.php
```

#### Forms Logic

Main logic and form handling done in:

```
laravel-app\app\Livewire\CalculateByIncomeComponent.php
laravel-app\app\Livewire\CalculateByValueComponent.php

API Key is set in .env
```

Along with the front-end blade:

```
laravel-app\resources\views\livewire\calculate-results.blade.php
```

Filament forms are stored in:

```
laravel-app\App\Filament
```

#### Tests

Tests are found in:

```
laravel-app\tests\Feature\CalculateByIncomeComponentTest.php
laravel-app\tests\Feature\CalculateByValueComponentTest.php

Run the tests with:
php artisan test
```

## Features

- **Responsive UI**: Built with Tailwind CSS for a modern design.
- **Fiament Forms**: Utilizes Filament for easy form setup
- **API Integration**: Utilizes Saloon for robust HTTP requests.
- **Unit Tests**: Robust API testing for certainty.

## Usage

Access the application via the development server URL (e.g., http://localhost:9000).

## Remarks:

#### Errors

I couldn't figure out why the Livewire routing/update wasn't working in time.

As a result, I made the API call execute by default. It might work for you. The calculate button uses the same routing.

#### What I could've done better

1. The 2 components that handle API requests are very similar, and contain duplicate code. Theres probably a neater way but I figured it's better like this for the assesment.

2. Should probably cache the results for performance sake.

3. Take way more time testing! In a real application for sure.
