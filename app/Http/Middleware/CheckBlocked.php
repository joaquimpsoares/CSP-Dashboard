<?php

namespace App\Http\Middleware;

use App\Provider;
use App\Models\Status;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBlocked
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
        if (Auth::check() && Auth::user()->status->id >= 2 && Auth::user()->status->id) {
            $status = Status::where('id', Auth::user()->status->id)->first();
            $message = 'Your account is '. ucwords(trans_choice($status->name, 1)) . ' . Please contact your system administrator.';
            Auth::logout();
			return redirect()->route('login')->withMessage($message);
        }
        return $next($request);
    }
}
