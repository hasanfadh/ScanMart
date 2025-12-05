<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('is_admin')) {
            return redirect()->route('admin.login')->with('error', 'Please login as admin!');
        }

        return $next($request);
    }
}