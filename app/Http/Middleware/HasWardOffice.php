<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasWardOffice
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
        if(!$request->user()->ward_id && !$request->user()->office_id) {
            // Send user to register page
            return redirect()->route('selectArea');
        } else {
            return $next($request);
        }
    }
}
