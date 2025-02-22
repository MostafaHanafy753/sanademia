<?php

namespace App\Http\Middleware;

use App\Models\BusinessSetting;
use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\HttpFoundation\Response;

class CalculateVisits
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $page_url = $request->path();

            $agent = new Agent();
            // Get the platform
            $platform = $agent->platform();
            $platformVersion = $agent->version($platform);

            // Get the browser
            $browser = $agent->browser();
            $browserVersion = $agent->version($browser);

            // Get device type
            $device = $agent->device();
            $isMobile = $agent->isMobile();
            $isTablet = $agent->isTablet();
            $isDesktop = $agent->isDesktop();
            $isRobot = $agent->isRobot();


            if (strtolower($device) != 'bot'||!$isRobot)
            {
                $visit = Visit::query()->firstOrCreate([
                    'ip' => $request->ip(),
                    'page_url' => $page_url,
                ]);
                $visit->ip = $request->ip();

                $locationData=Location::get($request->ip());

                $visit->country = $locationData?->countryName;
                $visit->country_code = $locationData?->countryCode;
                $visit->city = $locationData?->cityName;
                $visit->platform = $platform ?? null;
                $visit->platform_version = $platformVersion ?? null;
                $visit->browser = $browser ?? null;
                $visit->browser_version = $browserVersion ?? null;
                $visit->device = $device ?? null;
                $visit->is_mobile = $isMobile ?? 0;
                $visit->is_tablet = $isTablet ?? 0;
                $visit->is_desktop = $isDesktop ?? 0;
                $visit->page_url = $page_url;
                $visit->save();

            }
            $request->session()->put('mark_page_'.$page_url.'_as_visited', true);
            return $next($request);
        } catch (\Exception $e) {
            Log::error('CalculateVisits Middleware Error: ' . $e->getMessage());
            return $next($request);
        }
    }

}
