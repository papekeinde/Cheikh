<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->cookie('is_owner')) {
            return $response;
        }

        try {
            $ip = $request->ip();
            $geo = $this->geolocate($ip);

            Visit::create([
                'ip_hash'    => hash('sha256', $ip . config('app.key')),
                'path'       => mb_substr($request->path(), 0, 500),
                'method'     => $request->method(),
                'user_agent' => mb_substr($request->userAgent() ?? '', 0, 500),
                'referer'    => mb_substr($request->header('referer', ''), 0, 500) ?: null,
                'country'    => $geo['country'] ?? null,
                'city'       => $geo['city'] ?? null,
                'region'     => $geo['region'] ?? null,
            ]);
        } catch (\Throwable $e) {
            // Never break the request if tracking fails
        }

        return $response;
    }

    private function geolocate(string $ip): array
    {
        try {
            if (in_array($ip, ['127.0.0.1', '::1']) || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
                return ['country' => 'Local', 'city' => 'Local', 'region' => 'Local'];
            }

            $response = Http::timeout(2)->get("http://ip-api.com/json/{$ip}?fields=country,city,regionName");

            if ($response->successful() && $response->json('country')) {
                return [
                    'country' => $response->json('country'),
                    'city'    => $response->json('city'),
                    'region'  => $response->json('regionName'),
                ];
            }
        } catch (\Throwable $e) {
            // Silent fail
        }

        return [];
    }
}
