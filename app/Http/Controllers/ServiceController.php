<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $mainServices       = Service::where('is_main', true)->with('features')->orderBy('order')->get();
        $supportingServices = Service::where('is_main', false)->orderBy('order')->get();
        $settings           = \App\Models\ServiceSetting::firstOrNew(['id' => 1]);

        return view('user.services', compact('mainServices', 'supportingServices', 'settings'));
    }
}