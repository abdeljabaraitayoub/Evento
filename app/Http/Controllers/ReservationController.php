<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorereservationRequest;
use App\Http\Requests\UpdatereservationRequest;
use App\Models\reservation;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = reservation::all();
        return response()->json($reservations, 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorereservationRequest $request)
    {
        $reservation = new reservation();
        $reservation->user_id = Auth::id();
        $reservation->event_id = $request->event_id;
        $event = Event::findOrFail($request->event_id);
        if ($event->auto_approve) {
            $reservation->save();
            $reservation->confirmed = 1;
            TicketController::store($reservation, $event);
            return response()->json(["reservation" => $reservation, "message" => "verify your email please"], 201);
        }
        $reservation->save();

        return response()->json(["reservation" => $reservation, "message" => "wait till the organizer accept your reservation"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(reservation $reservation)
    {
        return response()->json($reservation, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatereservationRequest $request, reservation $reservation)
    {
        $reservation->event_id = $request->event_id;
        $reservation->save();
        return response()->json($reservation, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(reservation $reservation)
    {
        $reservation->deleted_at = date('Y-m-d H:i:s');
        $reservation->save();
        return response()->json(null, 204);
    }
    public function getEventReservations(Event $Event)
    {
        $reservations = reservation::join('users', 'users.id', '=', 'reservations.user_id')
            ->join('events', 'events.id', '=', 'reservations.event_id')
            ->where('reservations.deleted_at', null)

            ->where('event_id', $Event->id)
            ->select('reservations.*', 'events.title', 'events.auto_approve', 'users.name')
            ->get();
        return response()->json($reservations, 200);
    }
    public function confirmReservation(reservation $reservation)
    {
        if ($reservation->confirmed) {
            $reservation->confirmed = 0;
        } else {
            $reservation->confirmed = 1;
            TicketController::store($reservation);
        }
        $reservation->save();
        return response()->json($reservation, 200);
    }

    public function statistics(Event $Event)
    {
        $reservations = reservation::all()->where('event_id', $Event->id)->count();
        $confirmed = reservation::where('confirmed', 1)->where('event_id', $Event->id)->count();
        $unconfirmed = reservation::where('confirmed', 0)->where('event_id', $Event->id)->count();
        return response()->json(['Total' => $reservations, 'confirmed' => $confirmed, 'unconfirmed' => $unconfirmed], 200);
    }
}
