<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceFeature;
use App\Models\ServiceSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Throwable;

class ServiceController extends Controller
{
    public function index()
    {
        $mainServices       = Service::where('is_main', true)->with('features')->orderBy('order')->get();
        $supportingServices = Service::where('is_main', false)->orderBy('order')->get();
        $settings           = ServiceSetting::firstOrNew(['id' => 1]);

        return view('admin.services.index', compact('mainServices', 'supportingServices', 'settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'services_hero_title'    => 'required|string',
            'services_hero_subtitle' => 'nullable|string',
            'services_hero_image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'remove_hero_image'      => 'nullable|boolean',
            'intro_text'             => 'nullable|string',
        ]);

        $settings = ServiceSetting::firstOrNew(['id' => 1]);
        $settings->hero_title = $request->services_hero_title;
        $settings->hero_subtitle = $request->services_hero_subtitle;
        $settings->intro_text = $request->intro_text;

        if ($request->remove_hero_image == 1) {
            if ($settings->hero_image) {
                Storage::disk('public')->delete($settings->hero_image);
                $settings->hero_image = null;
            }
        } elseif ($request->hasFile('services_hero_image')) {
            if ($settings->hero_image) {
                Storage::disk('public')->delete($settings->hero_image);
            }
            try {
                $filename = 'services/' . Str::uuid() . '.webp';
                $path = storage_path('app/public/' . $filename);
                if (!is_dir(dirname($path))) {
                    mkdir(dirname($path), 0755, true);
                }
                Image::read($request->file('services_hero_image'))->cover(1920, 600)->toWebp(80)->save($path);
                $settings->hero_image = $filename;
            } catch (\Throwable $e) {
                $settings->hero_image = $request->file('services_hero_image')->store('services', 'public');
            }
        }

        $settings->save();

        if ($request->ajax() || $request->expectsJson() || $request->hasHeader('X-Requested-With')) {
            $request->session()->flash('success', 'Pengaturan Hero berhasil disimpan.');
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Pengaturan Hero berhasil disimpan.');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
                'is_main'     => 'required',
            ]);

            $isMain = filter_var($request->input('is_main'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? true;

            $data = [
                'name'        => $request->name,
                'description' => $request->description ?? '',
                'is_main'     => $isMain,
                'order'       => Service::where('is_main', $isMain)->max('order') + 1,
            ];

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('services', 'public');
            }

            $service = Service::create($data);

            if ($request->ajax() || $request->expectsJson() || $request->hasHeader('X-Requested-With')) {
                $request->session()->flash('success', 'Service berhasil disimpan');
                return response()->json(['id' => $service->id, 'success' => true]);
            }

            return back()->with('success', 'Service berhasil ditambahkan.');

        } catch (Throwable $e) {
            if ($request->ajax() || $request->expectsJson() || $request->hasHeader('X-Requested-With')) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function update(Request $request, Service $service)
    {
        try {
            $request->validate([
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string',
                'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            ]);

            $data = [
                'name'        => $request->name,
                'description' => $request->description ?? '',
            ];

            if ($request->hasFile('image')) {
                if ($service->image) {
                    Storage::disk('public')->delete($service->image);
                }
                $data['image'] = $request->file('image')->store('services', 'public');
            }

            $service->update($data);

            if ($request->ajax() || $request->expectsJson() || $request->hasHeader('X-Requested-With')) {
                $request->session()->flash('success', 'Service berhasil diperbarui');
                return response()->json(['success' => true]);
            }

            return back()->with('success', 'Service berhasil diperbarui.');

        } catch (Throwable $e) {
            if ($request->ajax() || $request->expectsJson() || $request->hasHeader('X-Requested-With')) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        $service->features()->delete();
        $service->delete();

        return back()->with('success', 'Service berhasil dihapus.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['order' => 'required|array']);

        foreach ($request->order as $index => $id) {
            Service::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    // ── Features ──────────────────────────────────────────────

    public function storeFeature(Request $request, Service $service)
    {
        $request->validate(['text' => 'required|string|max:255']);
        $feature = $service->features()->create(['text' => $request->text]);
        return response()->json(['id' => $feature->id, 'text' => $feature->text]);
    }

    public function updateFeature(Request $request, ServiceFeature $feature)
    {
        $request->validate(['text' => 'required|string|max:255']);
        $feature->update(['text' => $request->text]);
        return response()->json(['success' => true]);
    }

    public function destroyFeature(ServiceFeature $feature)
    {
        $feature->delete();
        return response()->json(['success' => true]);
    }
}
