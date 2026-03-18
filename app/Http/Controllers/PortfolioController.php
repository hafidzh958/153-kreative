<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\PortfolioCategory;

class PortfolioController extends Controller
{
    public function index()
    {
        $categories = PortfolioCategory::all();

        // Semua portfolio untuk filter per-kategori di JS, diurutkan by order
        $portfolios = Portfolio::with('category')
            ->orderBy('order')
            ->get();

        $settings = \App\Models\PortfolioSetting::firstOrNew(['id' => 1]);

        return view('user.portfolio', compact('categories', 'portfolios', 'settings'));
    }
}