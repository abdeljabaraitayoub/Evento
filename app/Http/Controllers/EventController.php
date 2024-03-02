<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        DB::enableQueryLog();

        $events = Event::where('deleted_at', null)
            ->where('category_id', 'LIKE', '%' . $request->category . '%')
            ->where('title', 'LIKE', '%' . $request->event . '%')
            ->paginate(5);

        $queries = DB::getQueryLog();

        return response()->json([
            'events' => $events,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        $event = new Event();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->location = $request->location;
        $event->start_date = $request->start_date;
        $event->capacity = $request->capacity;
        $event->user_id = $request->user_id;
        $event->category_id = $request->category_id;
        $event->save();
        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return response()->json($event, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->title = $request->title;
        $event->description = $request->description;
        $event->location = $request->location;
        $event->start_date = $request->start_date;
        $event->capacity = $request->capacity;
        $event->user_id = $request->user_id;
        $event->category_id = $request->category_id;
        $event->save();
        return response()->json($event, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->deleted_at = date('Y-m-d H:i:s');
        $event->save();
        return response()->json(NULL, 204);
    }
}
