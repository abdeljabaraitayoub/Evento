<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorereservationRequest;
use App\Http\Requests\UpdatereservationRequest;
use App\Models\reservation;

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
        $reservation->user_id = $request->user_id;
        $reservation->event_id = $request->event_id;
        $reservation->save();
        $ticket = TicketController::store($reservation->id);
        return response()->json(["reservation" => $reservation, "ticket" => $ticket], 201);
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
}
