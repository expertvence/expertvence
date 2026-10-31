<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfitDistribution;

class AdminProfitDistributionController extends Controller
{
    public function index()
    {
        $distributions = ProfitDistribution::with('member')
            ->orderBy('distribution_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($d) {
                return [
                    'id' => $d->id,
                    'member_id' => $d->member_id,
                    'member_name' => $d->member ? $d->member->name : 'Unknown Member',
                    'member_designation' => $d->member ? $d->member->designation : '',
                    'member_image' => $d->member ? $d->member->image : null,
                    'amount' => (float) $d->amount,
                    'distribution_date' => $d->distribution_date ? $d->distribution_date->format('Y-m-d') : null,
                    'comment' => $d->comment,
                    'created_at' => $d->created_at ? $d->created_at->format('Y-m-d') : null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $distributions,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'distribution_date' => 'required|date',
            'comment' => 'nullable|string|max:1000',
        ]);

        $distribution = ProfitDistribution::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Profit distribution recorded successfully!',
            'data' => $distribution->load('member'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $distribution = ProfitDistribution::findOrFail($id);

        $validated = $request->validate([
            'member_id' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'distribution_date' => 'required|date',
            'comment' => 'nullable|string|max:1000',
        ]);

        $distribution->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Profit distribution updated successfully!',
            'data' => $distribution->load('member'),
        ]);
    }

    public function destroy($id)
    {
        $distribution = ProfitDistribution::findOrFail($id);
        $distribution->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Profit distribution deleted successfully!',
        ]);
    }
}
