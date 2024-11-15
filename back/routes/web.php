<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Exports\ProductsExport;
use App\Exports\QueriesExport;
use App\Exports\VisitorsExport;
use App\Exports\UpdatesExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/export', function () {
    return Excel::download(new ProductsExport, 'data.xlsx');
});

Route::get('/queries', function () {
    return Excel::download(new QueriesExport, 'top_queries.xlsx');
});

Route::get('/visitors', function () {
    return Excel::download(new VisitorsExport, 'visitors.xlsx');
});


Route::get('/updates', function () {
    return Excel::download(new UpdatesExport, 'updates.xlsx');
});