<?php

use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

Route::get("/", fn() => ["message" => "API is running"]);

Route::get("/count", [TokenController::class, "count"]);
