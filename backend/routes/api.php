<?php

use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

Route::get("/", fn() => ["message" => "API is running"]);

Route::post("/count", [TokenController::class, "count"]);
