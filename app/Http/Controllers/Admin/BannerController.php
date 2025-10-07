<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $banners = Banner::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image_url' => 'nullable|url|max:2000',
            'image_file' => 'nullable|image|max:4096',
            'link' => 'nullable|url|max:2000',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'active' => 'sometimes|boolean'
        ]);

        // handle upload
        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $path = $file->store('banners', 'public');
            $imagePath = Storage::url($path);
            $data['image_path'] = $path;
        }

        if (!empty($data['image_url'])) {
            // prefer an external URL if provided; keep image_path empty
        }

        $data['active'] = isset($data['active']) ? (bool)$data['active'] : true;

        $banner = Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'image_url' => 'nullable|url|max:2000',
            'image_file' => 'nullable|image|max:4096',
            'link' => 'nullable|url|max:2000',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after_or_equal:start_at',
            'active' => 'sometimes|boolean'
        ]);

        if ($request->hasFile('image_file')) {
            // delete old file if exists
            if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $path = $request->file('image_file')->store('banners', 'public');
            $data['image_path'] = $path;
            // clear image_url if local upload
            $data['image_url'] = null;
        }

        $data['active'] = isset($data['active']) ? (bool)$data['active'] : false;

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image_path && Storage::disk('public')->exists($banner->image_path)) {
            Storage::disk('public')->delete($banner->image_path);
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted');
    }
}
