<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;

class CategoryController extends Controller
{
    public function indexIncome()
    {
        $categories = Categories::where('status_kategori', 'pemasukkan')->get();

        return response()->json([
            'status' => 'success',
            'data' => $categories,
        ]);
    }

    public function indexOutcome()
    {
        $categories = Categories::where('status_kategori', 'pengeluaran')->get();

        return response()->json([
            'status' => 'success',
            'data' => $categories,
        ]);
    }
}
