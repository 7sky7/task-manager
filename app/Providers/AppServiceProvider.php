<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // デフォルトはTailwind CSS向けのため、画面全体で使っているBootstrap5に合わせる
        Paginator::useBootstrapFive();
    }
}
