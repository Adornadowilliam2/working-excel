<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\UpdateController;  

Route::prefix("products")->group(function(){
    Route::get("/retrieve", [ProductController::class, "index"]);
    Route::post("/add", [ProductController::class, "store"]);
    Route::post("/update", [ProductController::class, "update"]);
    Route::post("/delete", [ProductController::class, "destroy"]);
});

Route::prefix("queries")->group(function(){
    Route::get("/retrieve", [QueryController::class, "index"]);
    Route::post("/add", [QueryController::class, "store"]);
    Route::post("/update", [QueryController::class, "update"]);
    Route::post("/delete", [QueryController::class, "destroy"]);
});

Route::prefix("visitors")->group(function(){
    Route::get("/retrieve", [VisitorController::class, "index"]);
    Route::post("/add", [VisitorController::class, "store"]);
    Route::post("/update", [VisitorController::class, "update"]);
    Route::post("/delete", [VisitorController::class, "destroy"]);
});

Route::prefix("updates")->group(function(){
    // Retrieve all visit updates
    Route::get("/retrieve", [UpdateController::class, "index"]);

    // Add a new visit update record
    Route::post("/add", [UpdateController::class, "store"]);

    // Update an existing visit update record
    Route::post("/update", [UpdateController::class, "update"]);

    // Delete a visit update record
    Route::post("/delete", [UpdateController::class, "destroy"]);
});
