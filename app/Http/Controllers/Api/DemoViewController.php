<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DemoView;
use App\Models\ReadySoftwareDemo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class DemoViewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'demo_id' => 'required|uuid|exists:ready_software_demos,id',
        ]);

        $user = null;
        try {
            $user = auth('api')->user();
        } catch (Throwable $exception) {
            // Keep an anonymous view record even if an expired token was sent.
        }

        $view = DemoView::create([
            'ready_software_demo_id' => $data['demo_id'],
            'user_id' => $user?->id,
            'visitor_ip' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 1000, ''),
        ]);

        return response()->json(['status' => 'success', 'id' => $view->id], 201);
    }

    public function index()
    {
        $views = DemoView::with([
            'demo:id,title',
            'user:id,name,email',
        ])->latest()->limit(500)->get()->map(fn (DemoView $view) => [
            'id' => $view->id,
            'demo_title' => $view->demo?->title ?? 'Deleted demo',
            'viewer_name' => $view->user?->name ?? 'Guest visitor',
            'viewer_email' => $view->user?->email,
            'visitor_ip' => $view->visitor_ip,
            'user_agent' => $view->user_agent,
            'viewed_at' => $view->created_at?->toIso8601String(),
        ]);

        return response()->json(['status' => 'success', 'data' => $views]);
    }
}
