<?php

namespace App\Http\Middleware;

use App\Models\GuestSession;
use App\Models\GuestRequest;
use Closure;
use Illuminate\Support\Facades\Auth;

class TrackGuestMiddleware
{
    public function handle($request, Closure $next)
    {
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');
        $deviceHash = sha1($ipAddress . $userAgent);

        //mine
        $guestSession = GuestSession::query()->where('device_hash', $deviceHash)->first();
        //

        if (Auth::check()) {
            $user = Auth::user();

            GuestRequest::query()->create([
                'guest_session_id' => $guestSession->id, // No guest session
                'user_id' => $user->id,
                'endpoint' => $request->path(),
                'method' => $request->method(),
                'request_data' => json_encode($request->all()),
            ]);

            return $next($request);
        }

        // Guest user logic
        // $guestSession = GuestSession::query()->where('device_hash', $deviceHash)->first();

        if (!$guestSession) {
            $deviceCount = GuestSession::query()->where('ip_address', $ipAddress)->count();

            if ($deviceCount >= 5) {
                return response()->json([
                    'error' => 'Device limit exceeded for this IP. Please log in.'
                ], 403);
            }

            $guestSession = GuestSession::query()->create([
                'ip_address' => $ipAddress,
                'device_hash' => $deviceHash,
                'os_type' => $this->getOS($userAgent),
                'user_agent' => $userAgent,
                'last_activity' => now(),
                'status' => 'guest',
            ]);
        } else {
            $guestSession->update(['last_activity' => now()]);
        }

        GuestRequest::query()->create([
            'guest_session_id' => $guestSession->id,
            'endpoint' => $request->path(),
            'method' => $request->method(),
            'request_data' => json_encode($request->all()),
        ]);

        return $next($request);
    }

    private function getOS($userAgent): string
    {
        $osArray = [
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/macintosh|mac os x/i' => 'Mac OS',
            '/linux/i' => 'Linux',
            '/iphone/i' => 'iOS',
            '/android/i' => 'Android',
        ];

        foreach ($osArray as $regex => $os) {
            if (preg_match($regex, $userAgent)) {
                return $os;
            }
        }

        return 'Unknown OS';
    }
}
