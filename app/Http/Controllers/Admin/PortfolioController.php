<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portfolio;
use App\Models\PortfolioCategory;
use App\Models\PortfolioSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class PortfolioController extends Controller
{
    public function index(): View
    {
        // Load categories with their portfolios ordered by drag-drop position
        $categories = PortfolioCategory::with(['portfolios' => function ($q) {
            $q->orderBy('order');
        }])->get();

        $settings = PortfolioSetting::firstOrNew(['id' => 1]);

        return view('admin.portfolio.index', compact('categories', 'settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'portfolio_hero_title'    => 'required|string',
            'portfolio_hero_subtitle' => 'nullable|string',
        ]);

        $settings = PortfolioSetting::firstOrNew(['id' => 1]);
        $settings->hero_title = $request->portfolio_hero_title;
        $settings->hero_subtitle = $request->portfolio_hero_subtitle;
        $settings->save();

        if ($request->ajax() || $request->expectsJson() || $request->hasHeader('X-Requested-With')) {
            $request->session()->flash('success', 'Pengaturan teks Portofolio berhasil disimpan.');
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Pengaturan teks Portofolio berhasil disimpan.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'nullable|string|max:255',
            'category_id'     => 'required|exists:portfolio_categories,id',
            'image'           => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'is_featured'     => 'nullable',
            'is_show_in_all'  => 'nullable',
        ]);

        $data = $request->only(['title', 'category_id']);
        $data['is_show_in_all'] = $request->input('is_show_in_all') == '1';

        // Find max order
        $data['order'] = Portfolio::max('order') + 1;

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request->file('image'));
        }

        Portfolio::create($data);

        if ($request->ajax() || $request->expectsJson() || $request->hasHeader('X-Requested-With')) {
            $request->session()->flash('success', 'Portfolio berhasil ditambahkan.');
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Portfolio berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);

        $request->validate([
            'title'           => 'nullable|string|max:255',
            'category_id'     => 'required|exists:portfolio_categories,id',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'is_featured'     => 'nullable',
            'is_show_in_all'  => 'nullable',
        ]);

        $data = $request->only(['title', 'category_id']);
        $data['is_show_in_all'] = $request->input('is_show_in_all') == '1';

        if ($request->hasFile('image')) {
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }
            $data['image'] = $this->storeImage($request->file('image'));
        }

        $portfolio->update($data);

        if ($request->ajax() || $request->expectsJson() || $request->hasHeader('X-Requested-With')) {
            $request->session()->flash('success', 'Portfolio berhasil diperbarui.');
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Portfolio berhasil diperbarui.');
    }

    public function destroy(Request $request, $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        
        if ($portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        if ($request->ajax() || $request->expectsJson() || $request->hasHeader('X-Requested-With')) {
            $request->session()->flash('success', 'Portfolio berhasil dihapus.');
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Portfolio berhasil dihapus.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:portfolios,id',
            'items.*.order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            Portfolio::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Urutan berhasil disimpan.']);
    }

    /**
     * Auto-resize & compress image to 1200x900 (4:3) WebP.
     * Falls back to plain store() if Intervention Image fails.
     */
    private function storeImage($file): string
    {
        try {
            $filename = 'portfolio/' . Str::uuid() . '.webp';
            $path     = storage_path('app/public/' . $filename);

            // Ensure directory exists
            if (!is_dir(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }

            Image::read($file)
                ->cover(1200, 900)   // crop & resize to exact 4:3 ratio
                ->toWebp(80)         // compress to 80%
                ->save($path);

            return $filename;
        } catch (\Throwable $e) {
            // Fallback: store original file unchanged
            return $file->store('portfolio', 'public');
        }
    }
}

