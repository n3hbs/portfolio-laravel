<?php

namespace App\Providers;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('contact-limiter', function (Request $request) {
            return Limit::perMinute(1)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'status'  => 429,
                        'message' => 'Too many messages sent. Please wait a minute before trying again.',
                    ], 429);
                });
        });
        // General API rate limiter: 60 per minute
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(20)->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        'message' => 'Too many requests. Please slow down.',
                    ], 429, $headers);
                });
        });
    }
}
