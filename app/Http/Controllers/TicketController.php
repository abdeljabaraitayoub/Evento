<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\reservation;
use App\Models\Ticket;

use Illuminate\Support\Facades\Hash;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::all();
        return response()->json($tickets, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public static function store($reservation_id)
    {
        $reservation = reservation::find($reservation_id);
        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found'], 404);
        }

        $date = date('Y-m-d H:i:s');

        $concatenatedString = "{$date}-{$reservation->id}-{$reservation->user_id}-{$reservation->event_id}";

        $code = Hash::make($concatenatedString);

        $ticket = new Ticket();
        $ticket->reservation_id = $reservation_id;
        $ticket->code = $code;
        $ticket->save();

        return $ticket;
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return response()->json($ticket, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->reservation_id = $request->reservation_id;
        $ticket->save();
        return response()->json($ticket, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json(null, 204);
    }
}
