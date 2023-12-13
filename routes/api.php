<?php

use App\Http\Controllers\Drone\DroneController;
use Illuminate\Support\Facades\Route;


Route::get('drones/move', [DroneController::class, 'move']);
