<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\reservation;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class StatistiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = reservation::all()->count();
        $events = Event::all()->count();
        $users = User::all()->count();
        $tickets = Ticket::all()->count();
        return response()->json([
            'total_events' => $events,
            'total_reservations' => $reservations,
            'total_users' => $users,
            'total_tickets' => $tickets,
        ], 200);
    }
}
