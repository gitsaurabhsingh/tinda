<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use Illuminate\Support\Facades\Http;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Don't track admin routes or API routes
        if ($request->is('admin/*') || $request->is('api/*')) {
            return $next($request);
        }

        $ip = $request->ip();
        $today = now()->format('Y-m-d');
        
        // Use a cache or session to avoid querying DB on every single request
        // For simplicity here, we'll just check if a record exists for this IP today
        $visited = Visitor::where('ip_address', $ip)
                          ->where('visited_date', $today)
                          ->exists();
                          
        if (!$visited) {
            $country = 'Unknown';
            
            // Attempt to get country from IP (free API)
            try {
                // If it's localhost, we can't get a real country
                if ($ip !== '127.0.0.1' && $ip !== '::1') {
                    $response = Http::timeout(2)->get("http://ip-api.com/json/{$ip}");
                    if ($response->successful() && $response->json('status') === 'success') {
                        $country = $response->json('country');
                    }
                } else {
                    $country = 'Localhost';
                }
            } catch (\Exception $e) {
                // Ignore timeout/API errors to not slow down the site
            }
            
            Visitor::create([
                'ip_address' => $ip,
                'country' => $country,
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl(),
                'visited_date' => $today,
            ]);
        }

        return $next($request);
    }
}
