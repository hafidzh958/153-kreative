<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\ContactSetting;

class ContactController extends Controller
{
    public function index(): View
    {
        $contact = ContactSetting::firstOrNew(['id' => 1]);
        return view('user.contact', compact('contact'));
    }
}
