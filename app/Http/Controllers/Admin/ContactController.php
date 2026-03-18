<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactSetting;

class ContactController extends Controller
{
    public function index()
    {
        $contact = ContactSetting::firstOrNew(['id' => 1]);
        return view('admin.contact.index', compact('contact'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_title'       => 'required|string|max:255',
            'hero_subtitle'    => 'nullable|string',
            'address'          => 'nullable|string',
            'email'            => 'required|email|max:255',
            'whatsapp'         => 'required|string|max:50',
            'whatsapp_message' => 'nullable|string',
            'phone'            => 'nullable|string|max:50',
            'cta_title'        => 'nullable|string|max:255',
            'cta_description'  => 'nullable|string',
            'map_link'         => 'nullable|string|max:1000',
            'latitude'         => 'nullable|string|max:30',
            'longitude'        => 'nullable|string|max:30',
        ]);

        ContactSetting::updateOrCreate(
            ['id' => 1],
            $request->only([
                'hero_title', 'hero_subtitle', 'address', 'email',
                'whatsapp', 'whatsapp_message', 'phone',
                'cta_title', 'cta_description',
                'map_link', 'latitude', 'longitude',
            ])
        );

        return back()->with('success', 'Konten Contact berhasil diperbarui.');
    }
}
