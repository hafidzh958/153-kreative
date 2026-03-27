<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('order')->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
        ]);

        $order = Client::max('order') + 1;
        $logoPath = $request->file('logo')->store('clients', 'public');

        Client::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'order' => $order,
            'is_visible' => $request->has('is_visible'),
        ]);

        return back()->with('success', 'Mitra berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:4096',
        ]);

        $client->name = $request->name;
        $client->is_visible = $request->has('is_visible');

        if ($request->hasFile('logo')) {
            if ($client->logo) {
                Storage::disk('public')->delete($client->logo);
            }
            $client->logo = $request->file('logo')->store('clients', 'public');
        }

        $client->save();
        return back()->with('success', 'Mitra berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        if ($client->logo) {
            Storage::disk('public')->delete($client->logo);
        }
        $client->delete();
        return back()->with('success', 'Mitra berhasil dihapus.');
    }
}
