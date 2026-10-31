<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReadySoftwareDemo;
use Illuminate\Http\Request;

class ReadySoftwareDemoController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => ReadySoftwareDemo::where('is_active', true)->orderBy('sort_order')->orderBy('created_at')->get(['id', 'icon', 'tag', 'title', 'description', 'features', 'demo_url', 'sort_order', 'is_active']),
        ]);
    }

    public function show(string $id)
    {
        $demo = ReadySoftwareDemo::where('is_active', true)->findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $demo]);
    }

    public function adminIndex()
    {
        return response()->json([
            'status' => 'success',
            'data' => ReadySoftwareDemo::orderBy('sort_order')->orderBy('created_at')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $demo = ReadySoftwareDemo::create($this->validated($request));
        return response()->json(['status' => 'success', 'data' => $demo], 201);
    }

    public function update(Request $request, string $id)
    {
        $demo = ReadySoftwareDemo::findOrFail($id);
        $demo->update($this->validated($request));
        return response()->json(['status' => 'success', 'data' => $demo->fresh()]);
    }

    public function destroy(string $id)
    {
        ReadySoftwareDemo::findOrFail($id)->delete();
        return response()->json(['status' => 'success']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'icon' => 'nullable|string|max:30',
            'tag' => 'required|string|max:120',
            'title' => 'required|string|max:180',
            'description' => 'required|string|max:2000',
            'features' => 'required|array|min:1|max:12',
            'features.*' => 'required|string|max:255',
            'demo_url' => 'nullable|url|max:2048',
            'admin_demo_url' => 'nullable|url|max:2048',
            'admin_demo_email' => 'nullable|email|max:255',
            'admin_demo_password' => 'nullable|string|max:255',
            'user_demo_url' => 'nullable|url|max:2048',
            'user_demo_email' => 'nullable|email|max:255',
            'user_demo_password' => 'nullable|string|max:255',
            'website_url' => 'nullable|url|max:2048',
            'sort_order' => 'nullable|integer|min:0|max:100000',
            'is_active' => 'required|boolean',
        ]);
    }
}
