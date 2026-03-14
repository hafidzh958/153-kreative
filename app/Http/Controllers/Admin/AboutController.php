<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSetting;
use App\Models\Mission;
use App\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $about = AboutSetting::first();
        if (!$about) {
            $about = new AboutSetting([
                'hero_title' => 'Tentang 153 Kreatif',
                'hero_subtitle' => 'Integrated Event Solutions & Creative Production',
                'story_title' => 'Cerita Kami',
                'story_description' => "153 Kreatif adalah perusahaan jasa manajemen acara dan produksi kreatif yang berdedikasi untuk memberikan solusi pemasaran terpadu.\n\nKami mengombinasikan keahlian eksekusi lapangan dengan kemampuan produksi manufaktur dan desain teknis untuk menciptakan pengalaman yang berdampak bagi klien dan audiens.",
                'vision_text' => 'Menjadi mitra strategis terdepan di industri manajemen acara dan produksi kreatif yang mengintegrasikan inovasi desain visual dengan kesempurnaan eksekusi lapangan.'
            ]);
        }
        
        $missions = Mission::orderBy('order')->get();
        if ($missions->isEmpty()) {
            $missions = collect([
                (object)['id' => 'temp_1', 'title' => '', 'description' => 'Memberikan solusi pemasaran terpadu melalui pameran otomotif dan aktivasi brand di lokasi strategis.'],
                (object)['id' => 'temp_2', 'title' => '', 'description' => 'Menjamin kualitas produksi material seperti backdrop, neon box, dan konstruksi booth dengan standar tinggi.']
            ]);
        }

        $processes = Process::orderBy('order')->get();
        if ($processes->isEmpty()) {
            $processes = collect([
                (object)['id' => 'temp_p1', 'title' => 'Consultation', 'description' => 'Berdiskusi bersama mendalami brief dan KPI dari kampanye Anda.'],
                (object)['id' => 'temp_p2', 'title' => 'Concept & Planning', 'description' => 'Menyusun moodboard visual, merancang agenda, dan pembagian tugas.'],
                (object)['id' => 'temp_p3', 'title' => 'Production', 'description' => 'Mengeksekusi desain, perizinan, panggung, serta instrumen marketing.'],
                (object)['id' => 'temp_p4', 'title' => 'Execution', 'description' => 'Hari-H. Kami memastikan seluruh skenario acara berjalan tepat waktu.'],
            ]);
        }
        return view('admin.about.index', compact('about', 'missions', 'processes'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'hero_title'        => 'required|string|max:255',
            'hero_subtitle'     => 'required|string|max:255',
            'story_title'       => 'required|string|max:255',
            'story_description' => 'required|string',
            'story_image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'vision_text'       => 'required|string',
            'missions_data'     => 'nullable|string',
            'processes_data'    => 'nullable|string',
        ]);

        $about = AboutSetting::firstOrNew(['id' => 1]);

        $about->hero_title        = $request->hero_title;
        $about->hero_subtitle     = $request->hero_subtitle;
        $about->story_title       = $request->story_title;
        $about->story_description = $request->story_description;
        $about->vision_text       = $request->vision_text;

        if ($request->hasFile('story_image')) {
            if ($about->story_image) {
                Storage::disk('public')->delete($about->story_image);
            }
            $about->story_image = $request->file('story_image')
                ->store('about', 'public');
        }

        $about->save();

        // Sync Missions
        if ($request->has('missions_data')) {
            $missionsData = json_decode($request->missions_data, true) ?? [];
            $keepMissionIds = collect($missionsData)->pluck('id')->filter(fn($id) => is_numeric($id))->toArray();
            Mission::whereNotIn('id', $keepMissionIds)->delete();

            foreach ($missionsData as $index => $m) {
                if (is_numeric($m['id'] ?? null)) {
                    Mission::where('id', $m['id'])->update([
                        'title' => $m['title'] ?? '',
                        'description' => $m['description'],
                        'order' => $index
                    ]);
                } else {
                    Mission::create([
                        'title' => $m['title'] ?? '',
                        'description' => $m['description'],
                        'order' => $index
                    ]);
                }
            }
        }

        // Sync Processes
        if ($request->has('processes_data')) {
            $processesData = json_decode($request->processes_data, true) ?? [];
            $keepProcessIds = collect($processesData)->pluck('id')->filter(fn($id) => is_numeric($id))->toArray();
            Process::whereNotIn('id', $keepProcessIds)->delete();

            foreach ($processesData as $index => $p) {
                if (is_numeric($p['id'] ?? null)) {
                    Process::where('id', $p['id'])->update([
                        'title' => $p['title'],
                        'description' => $p['description'],
                        'order' => $index
                    ]);
                } else {
                    $step_number = Process::max('step_number') + 1;
                    Process::create([
                        'title' => $p['title'],
                        'description' => $p['description'],
                        'step_number' => $step_number,
                        'order' => $index
                    ]);
                }
            }
        }

        return redirect()
            ->route('admin.about.index')
            ->with('success', 'Seluruh konten halaman About berhasil disimpan.');
    }
}
