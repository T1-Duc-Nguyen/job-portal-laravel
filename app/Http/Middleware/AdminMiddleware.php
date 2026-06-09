<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        // CHƯA LOGIN
        if (! Auth::check()) {

            return redirect('/admin/login');

        }

        // KHÔNG PHẢI ADMIN
        if (Auth::user()->role != 0) {

            abort(403);

        }

        return $next($request);
    }
}
