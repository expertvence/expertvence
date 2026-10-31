<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShareMember;
use Illuminate\Support\Facades\File;

class AdminShareMemberController extends Controller
{
    public function index()
    {
        $members = ShareMember::with('profitDistributions')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($m) {
                return [
                    'id' => $m->id,
                    'name' => $m->name,
                    'designation' => $m->designation,
                    'image' => $m->image,
                    'phone' => $m->phone,
                    'email' => $m->email,
                    'total_received' => (float) $m->profitDistributions->sum('amount'),
                    'created_at' => $m->created_at ? $m->created_at->format('Y-m-d') : null,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $members,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $uploadDir = public_path('uploads/members');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'member_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $imagePath = '/uploads/members/' . $filename;
        }

        $member = ShareMember::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'image' => $imagePath,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Share member added successfully!',
            'data' => $member,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $member = ShareMember::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'image_file' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = [
            'name' => $request->name,
            'designation' => $request->designation,
            'phone' => $request->phone,
            'email' => $request->email,
        ];

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $uploadDir = public_path('uploads/members');
            if (!File::exists($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true);
            }
            $filename = 'member_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $data['image'] = '/uploads/members/' . $filename;
        }

        $member->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Share member updated successfully!',
            'data' => $member,
        ]);
    }

    public function destroy($id)
    {
        $member = ShareMember::findOrFail($id);
        $member->profitDistributions()->delete();
        $member->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Share member deleted successfully!',
        ]);
    }
}
