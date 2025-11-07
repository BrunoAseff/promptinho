<?php

use Illuminate\Support\Facades\Route;

Route::get("/", fn() => ["message" => "API is running"]);
