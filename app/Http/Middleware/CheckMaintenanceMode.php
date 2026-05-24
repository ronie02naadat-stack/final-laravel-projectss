<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Maintenance;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip maintenance check for maintenance routes
        if ($request->is('maintenance*') || $request->is('maintenance-mode')) {
            return $next($request);
        }

        // Check if maintenance mode is active (uses getActive() which validates dates)
        $maintenance = Maintenance::getActive();
        
        if ($maintenance) {
            return redirect()->route('maintenance.show');
        }

        return $next($request);
    }
}
