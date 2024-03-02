<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $event = $request->route('Event');

        $reservation = $request->route('reservation');
        if ($reservation) {
            $event_id = $reservation->event_id;
            $event = Event::find($event_id);
        }
        if ($event->user_id !== Auth::user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
