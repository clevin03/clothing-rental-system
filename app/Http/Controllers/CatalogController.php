<?php

namespace App\Http\Controllers;

use App\Enums\ItemStatus;
use App\Models\Item;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $items = Item::query()
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%'.$request->search.'%'))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->when($request->filled('size'), fn ($q) => $q->where('size', $request->size))
            ->when(
                $request->filled('status') && ItemStatus::tryFrom($request->status),
                fn ($q) => $q->where('status', $request->status)
            )
            ->latest()
            ->get();

        $categories = Item::query()->distinct()->orderBy('category')->pluck('category');

        return view('catalog', compact('items', 'categories'));
    }
}
