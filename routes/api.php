<?php

use App\Http\Controllers\Drone\DroneController;
use Illuminate\Support\Facades\Route;

Route::post('drones/move', [DroneController::class, 'move'])->name('drones.move');
