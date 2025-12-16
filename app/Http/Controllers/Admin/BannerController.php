<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    public function index()
    {
        // Only admin users should manage banners
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        // Guard against missing banners table (migration not run yet)
        if (!\Illuminate\Support\Facades\Schema::hasTable('banners')) {
            // show empty list and an informative flash message
            session()->flash('warning', 'Tabel banners belum ada. Jalankan: php artisan migrate');

            // Provide an empty paginator so the view can call ->links() safely
            $banners = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10, 1, [
                'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
            ]);

            return view('admin.banners.index', compact('banners'));
        }

        $banners = Banner::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        // Pastikan hanya admin yang bisa menyimpan banner
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            // Accept full URL (https://...) or internal path starting with '/'
            'button_url' => ['nullable','string','max:255','regex:/^(?:https?:\/\/|\/).+/'],
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_active' => 'boolean',
            'image' => 'nullable|string|max:255',
            'image_upload' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:4096',
        ]);

        // Normalize button_url: if not empty and doesn't start with http(s) or '/', prepend '/'
        if (!empty($data['button_url']) && !Str::startsWith($data['button_url'], ['http://','https://','/'])) {
            $data['button_url'] = '/' . ltrim($data['button_url'], '/');
        }

        if ($request->hasFile('image_upload')) {
            $image = $request->file('image_upload');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('banners', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        $data['created_by'] = auth()->id();
        $data['is_active'] = $request->boolean('is_active');

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created');
    }

    public function edit(Banner $banner)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            // Accept full URL (https://...) or internal path starting with '/'
            'button_url' => ['nullable','string','max:255','regex:/^(?:https?:\/\/|\/).+/'],
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_active' => 'boolean',
            'image' => 'nullable|string|max:255',
            'image_upload' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:4096',
        ]);

        // Normalize button_url: if not empty and doesn't start with http(s) or '/', prepend '/'
        if (!empty($data['button_url']) && !Str::startsWith($data['button_url'], ['http://','https://','/'])) {
            $data['button_url'] = '/' . ltrim($data['button_url'], '/');
        }

        if ($request->hasFile('image_upload')) {
            $image = $request->file('image_upload');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('banners', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        $data['is_active'] = $request->boolean('is_active');

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated');
    }

    public function destroy(Banner $banner)
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted');
    }
}
