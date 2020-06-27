<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckDosen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role->role !== 'Dosen') {
            abort(403, 'Pelanggaran Hak Akses');
        }
        
        return $next($request);
    }
}
