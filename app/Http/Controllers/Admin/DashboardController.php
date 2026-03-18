<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $servicesCount = Service::count();
        $portfolioCount = Portfolio::count();
        $testimonialsCount = Testimonial::count();

        $recentPortfolios = Portfolio::latest()->take(5)->get()->map(fn ($p) => (object) [
            'type' => 'portfolio',
            'title' => $p->title,
            'url' => route('admin.portfolio.index'),
            'created_at' => $p->created_at,
        ]);
        $recentServices = Service::latest()->take(5)->get()->map(fn ($s) => (object) [
            'type' => 'service',
            'title' => $s->name,
            'url' => route('admin.services.index'),
            'created_at' => $s->created_at,
        ]);
        $recentActivity = $recentPortfolios->concat($recentServices)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'servicesCount',
            'portfolioCount',
            'testimonialsCount',
            'recentActivity'
        ));
    }
}

