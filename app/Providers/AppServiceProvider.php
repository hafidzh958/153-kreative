<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\FinanceSidebarComposer;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Provide sidebar badge counts to every finance view
        // without putting DB queries directly in Blade templates.
        View::composer('admin.layouts.finance', FinanceSidebarComposer::class);
    }
}
