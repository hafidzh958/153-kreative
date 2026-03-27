<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $home = HomeSetting::firstOrNew(['id' => 1]);
        $services = \App\Models\HomeService::latest()->get();
        $projects = \App\Models\HomeProject::latest()->get();
        return view('admin.home.index', compact('home', 'services', 'projects'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'hero_title'            => 'required|string|max:255',
            'hero_subtitle'         => 'required|string|max:255',
            'hero_description'      => 'nullable|string',
            'hero_button_text'      => 'required|string|max:255',
            'about_image'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            // New fields validation
            'stat_1_number'         => 'nullable|string|max:255',
            'stat_1_label'          => 'nullable|string|max:255',
            'stat_2_number'         => 'nullable|string|max:255',
            'stat_2_label'          => 'nullable|string|max:255',
            'stat_3_number'         => 'nullable|string|max:255',
            'stat_3_label'          => 'nullable|string|max:255',
            'stat_4_number'         => 'nullable|string|max:255',
            'stat_4_label'          => 'nullable|string|max:255',
            'showreel_title'        => 'nullable|string|max:255',
            'showreel_description'  => 'nullable|string',
            'showreel_video_url'    => 'nullable|string',
        ]);

        $home = HomeSetting::firstOrNew(['id' => 1]);

        $home->hero_title       = $request->hero_title;
        $home->hero_subtitle    = $request->hero_subtitle;
        $home->hero_description = $request->hero_description;
        $home->hero_button_text = $request->hero_button_text;
        $home->hero_button_link = $request->hero_button_link;
        $home->about_title      = $request->about_title;
        $home->about_description = $request->about_description;

        // Assign new fields
        $home->stat_1_number    = $request->stat_1_number;
        $home->stat_1_label     = $request->stat_1_label;
        $home->stat_2_number    = $request->stat_2_number;
        $home->stat_2_label     = $request->stat_2_label;
        $home->stat_3_number    = $request->stat_3_number;
        $home->stat_3_label     = $request->stat_3_label;
        $home->stat_4_number    = $request->stat_4_number;
        $home->stat_4_label     = $request->stat_4_label;
        $home->showreel_title   = $request->showreel_title;
        $home->showreel_description = $request->showreel_description;
        $home->showreel_video_url   = $request->showreel_video_url;

        if ($request->hasFile('hero_background_image')) {
            if ($home->hero_background_image) {
                Storage::disk('public')->delete($home->hero_background_image);
            }
            $home->hero_background_image = $request->file('hero_background_image')
                ->store('home', 'public');
        }

        if ($request->hasFile('about_image')) {
            if ($home->about_image) {
                Storage::disk('public')->delete($home->about_image);
            }
            $home->about_image = $request->file('about_image')
                ->store('home', 'public');
        }

        $home->save();

        return redirect()
            ->route('admin.home.index')
            ->with('success', 'Konten halaman Home (Hero, About, Stats, Showreel) berhasil diperbarui.');
    }

    // ─── SERVICES CRUD ──────────────────────────────────────────────

    public function storeService(Request $request): RedirectResponse
    {
        if (\App\Models\HomeService::count() >= 6) {
            return back()->with('error', 'Maksimal 6 layanan yang dapat ditambahkan.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $icons = [
            'bi-briefcase',
            'bi-lightning',
            'bi-megaphone',
            'bi-display',
            'bi-building',
            'bi-camera'
        ];
        $icon = $icons[array_rand($icons)];

        $order = \App\Models\HomeService::max('order') + 1;

        \App\Models\HomeService::create([
            'title' => $request->title,
            'icon' => $icon,
            'description' => $request->description,
            'order' => $order,
        ]);

        return back()->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function updateService(Request $request, $id): RedirectResponse
    {
        $service = \App\Models\HomeService::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $service->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Layanan berhasil diperbarui.');
    }

    public function deleteService($id): RedirectResponse
    {
        $service = \App\Models\HomeService::findOrFail($id);
        $service->delete();

        return back()->with('success', 'Layanan berhasil dihapus.');
    }

    public function reorderService(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:home_services,id',
        ]);

        foreach ($request->order as $index => $id) {
            \App\Models\HomeService::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    // ─── PROJECTS CRUD ──────────────────────────────────────────────

    public function storeProject(Request $request): RedirectResponse
    {
        if (\App\Models\HomeProject::count() >= 6) {
            return back()->with('error', 'Maksimal 6 project yang dapat ditambahkan.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'image_file' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $order = \App\Models\HomeProject::max('order') + 1;
        $imagePath = $request->file('image_file')->store('home_projects', 'public');

        \App\Models\HomeProject::create([
            'title' => $request->title,
            'image' => $imagePath,
            'order' => $order,
        ]);

        return back()->with('success', 'Project berhasil ditambahkan.');
    }

    public function updateProject(Request $request, $id): RedirectResponse
    {
        $project = \App\Models\HomeProject::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $project->title = $request->title;

        if ($request->hasFile('image_file')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $project->image = $request->file('image_file')->store('home_projects', 'public');
        }

        $project->save();

        return back()->with('success', 'Project berhasil diperbarui.');
    }

    public function deleteProject($id): RedirectResponse
    {
        $project = \App\Models\HomeProject::findOrFail($id);
        
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }
        $project->delete();

        return back()->with('success', 'Project berhasil dihapus.');
    }

    public function reorderProject(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'exists:home_projects,id',
        ]);

        foreach ($request->order as $index => $id) {
            \App\Models\HomeProject::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
