<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Job;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CanManageJob
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);

        $vacancy = Vacancy::find($request->id);

        if ($vacancy && $vacancy->user_id == Auth::id()) {
            return $next($request);
        }
        abort(403, 'You are not authorized to manage this job');
    }
}
