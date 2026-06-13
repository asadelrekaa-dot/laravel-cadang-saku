<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $budgets = Budget::with('kategori')
            ->where('user_id', $request->user()->id)
            ->get()
            ->map(fn($item) => [
                'id' => $item->id,
                'kategori_id' => $item->kategori_id,
                'kategori' => $item->kategori?->nama ?? 'Lainnya',
                'nominal' => (int) $item->nominal,
            ]);

        return response()->json([
            'status' => 'success',
            'data' => $budgets,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:categories,id',
            'nominal' => 'required|numeric|min:1',
        ]);

        $budget = Budget::create([
            'user_id' => $request->user()->id,
            'kategori_id' => $request->kategori_id,
            'nominal' => $request->nominal,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Budget berhasil ditambahkan',
            'data' => [
                'id' => $budget->id,
                'kategori_id' => $budget->kategori_id,
                'nominal' => (int) $budget->nominal,
            ],
        ], 201);
    }

    public function destroy(Request $request, $id)
    {
        $budget = Budget::where('user_id', $request->user()->id)
            ->findOrFail($id);

        $budget->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Budget berhasil dihapus',
        ]);
    }
}
