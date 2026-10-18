<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Models\Item;

Route::get('/catalog', function () {
    $items = Item::all();
    return view('catalog', compact('items'));
});