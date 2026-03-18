<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortfolioCategoryController extends Controller
{
    public function index()
    {
        $categories = PortfolioCategory::all();
        // Return view or JSON depending on how modal expects it
        // Or handle it in the same index view? The user asked for "Kategori Filter"
        return view('admin.portfolio.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        PortfolioCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return back()->with('success', 'Kategori Portfolio berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $category = PortfolioCategory::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return back()->with('success', 'Kategori Portfolio berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $category = PortfolioCategory::findOrFail($id);
        
        // Hapus file gambar dan record portofolio terkait
        foreach ($category->portfolios as $portfolio) {
            if ($portfolio->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($portfolio->image);
            }
            $portfolio->delete();
        }

        $category->delete();
        
        if (request()->ajax() || request()->expectsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Kategori Portfolio dan isinya berhasil dihapus.');
    }
}
