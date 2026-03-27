<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('order')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_position' => 'nullable|string|max:255',
            'quote' => 'required|string',
            'client_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $order = Testimonial::max('order') + 1;
        
        $photoPath = null;
        if ($request->hasFile('client_photo')) {
            $photoPath = $request->file('client_photo')->store('testimonials', 'public');
        }

        Testimonial::create([
            'client_name' => $request->client_name,
            'client_position' => $request->client_position,
            'quote' => $request->quote,
            'client_photo' => $photoPath,
            'order' => $order,
            'is_visible' => false,
        ]);

        $t = Testimonial::latest()->first();
        $t->is_visible = $request->has('is_visible') ? true : false;
        $t->save();

        return back()->with('success', 'Testimonial berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_position' => 'nullable|string|max:255',
            'quote' => 'required|string',
            'client_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $testimonial->client_name = $request->client_name;
        $testimonial->client_position = $request->client_position;
        $testimonial->quote = $request->quote;
        $testimonial->is_visible = $request->has('is_visible');

        if ($request->hasFile('client_photo')) {
            if ($testimonial->client_photo) {
                Storage::disk('public')->delete($testimonial->client_photo);
            }
            $testimonial->client_photo = $request->file('client_photo')->store('testimonials', 'public');
        }

        $testimonial->save();
        return back()->with('success', 'Testimonial berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        if ($testimonial->client_photo) {
            Storage::disk('public')->delete($testimonial->client_photo);
        }
        $testimonial->delete();
        return back()->with('success', 'Testimonial berhasil dihapus.');
    }
}
