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
        if (Auth::check()) {
            $statusId = (int) (Auth::user()->status_id ?? (Auth::user()->status->id ?? 0));

            // Allowed statuses (legacy app uses 5 = Enabled).
            $allowed = [1, 5];

            if (! in_array($statusId, $allowed, true)) {
                $status = Status::where('id', $statusId)->first();
                $name = $status?->name ?? 'blocked';
                $message = 'Your account is ' . ucwords(trans_choice($name, 1)) . '. Please contact your system administrator.';
                Auth::logout();
                return redirect()->route('login')->with('message', $message);
            }
        }
        return $next($request);
    }
}
