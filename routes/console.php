<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('store:health', function () {
    $this->info('Industrial commerce application is ready.');
})->purpose('Check application bootstrap health');
