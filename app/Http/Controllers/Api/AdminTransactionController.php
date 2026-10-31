<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectTransaction;

class AdminTransactionController extends Controller
{
    public function index()
    {
        $transactions = ProjectTransaction::with('project')
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'project_id' => $t->project_id,
                    'project_name' => $t->project ? $t->project->name : 'General / Direct',
                    'type' => $t->type,
                    'amount' => (float) $t->amount,
                    'transaction_date' => $t->transaction_date ? $t->transaction_date->format('Y-m-d') : null,
                    'description' => $t->description,
                    'created_at' => $t->created_at ? $t->created_at->format('Y-m-d') : null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $transactions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'project_id' => 'nullable|string',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $transaction = ProjectTransaction::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => ucfirst($transaction->type) . ' record added successfully!',
            'data' => $transaction->load('project'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $transaction = ProjectTransaction::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'project_id' => 'nullable|string',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $transaction->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction updated successfully!',
            'data' => $transaction->load('project'),
        ]);
    }

    public function destroy($id)
    {
        $transaction = ProjectTransaction::findOrFail($id);
        $transaction->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Transaction deleted successfully!',
        ]);
    }
}
