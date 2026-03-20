<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        try {
            Visit::create([
                'ip_hash'    => hash('sha256', $request->ip() . config('app.key')),
                'path'       => mb_substr($request->path(), 0, 500),
                'method'     => $request->method(),
                'user_agent' => mb_substr($request->userAgent() ?? '', 0, 500),
                'referer'    => mb_substr($request->header('referer', ''), 0, 500) ?: null,
            ]);
        } catch (\Throwable $e) {
            // Never break the request if tracking fails
        }

        return $response;
    }
}
