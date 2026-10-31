<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class AdminProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['transactions'])->orderBy('created_at', 'desc')->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'client_name' => $p->client_name,
                'client_address' => $p->client_address,
                'client_phone' => $p->client_phone,
                'project_url' => $p->project_url,
                'budget' => (float) $p->budget,
                'status' => $p->status,
                'income_total' => (float) $p->income_total,
                'expense_total' => (float) $p->expense_total,
                'created_at' => $p->created_at ? $p->created_at->format('Y-m-d') : null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $projects,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'client_address' => 'nullable|string',
            'client_phone' => 'nullable|string|max:50',
            'project_url' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|in:active,completed,on_hold',
        ]);

        $project = Project::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Project created successfully!',
            'data' => $project,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_name' => 'required|string|max:255',
            'client_address' => 'nullable|string',
            'client_phone' => 'nullable|string|max:50',
            'project_url' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'status' => 'nullable|string|in:active,completed,on_hold',
        ]);

        $project->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Project updated successfully!',
            'data' => $project,
        ]);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->transactions()->delete();
        $project->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Project and its associated transactions deleted successfully!',
        ]);
    }
}
