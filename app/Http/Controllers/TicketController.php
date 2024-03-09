<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Mail\SendTicket;
use App\Models\reservation;
use App\Models\Ticket;
use Dompdf\Dompdf;
use App\Mail\ResetPassword;



use SimpleSoftwareIO\QrCode\Facades\QrCode;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
    public static function store(reservation $reservation, $event = null)
    {
        if (!$reservation) {
            return response()->json(['error' => 'Reservation not found'], 404);
        }
        if ($reservation->confirmed == 0) {
            return response()->json(['error' => 'Reservation not confirmed'], 400);
        }
        $date = date('Y-m-d H:i:s');
        $concatenatedString = "{$date}-{$reservation->id}-{$reservation->user_id}-{$reservation->event_id}";
        $code = Hash::make($concatenatedString);
        $ticket = new Ticket();
        $ticket->reservation_id = $reservation->id;
        $ticket->code = $code;
        $ticket->save();
        $qrCode = base64_encode(QrCode::format('png')->size(200)->generate($ticket->code));
        $pdf = new Dompdf();
        $html = view('qr-codes', compact('qrCode', 'event', 'reservation'));
        $pdf->loadHtml($html);

        $pdf->setPaper(array(0, 0, 200, 400));

        $pdf->render();
        $output = $pdf->output();
        file_put_contents('../storage/tickets/' . $ticket->reservation_id . '.pdf', $output);
        Mail::to("abdeljabarayoubi@gmail.com")->send(new SendTicket("../storage/tickets/" . $ticket->reservation_id . '.pdf'));
        return response()->json($ticket, 201);
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
    public function generate()
    {
        // return view('qr-codes', compact('qrCode'));
    }
}
