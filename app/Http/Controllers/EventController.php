<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            ->where('region_id', 'LIKE', '%' . $request->region . '%')
            ->where('is_valid', 1)
            ->where('deleted_at', null);

        if ($request->date == 'month') {
            $events->where('start_date', '>=', Carbon::now()->startOfMonth());
            $events->where('start_date', '<=', Carbon::now()->endOfMonth());
        };
        if ($request->date == 'week') {
            $events->where('start_date', '>=', Carbon::now()->startOfWeek());
            $events->where('start_date', '<=', Carbon::now()->endOfWeek());
        };
        if ($request->date == 'day') {
            $events->where('start_date', '>=', Carbon::now()->startOfDay());
            $events->where('start_date', '<=', Carbon::now()->endOfDay());
        };

        $events = $events->paginate(5);
        $queries = DB::getQueryLog();

        return response()->json(
            $events,
            200
        );
    }

    public function all()
    {
        $events = Event::whereNull('deleted_at')->get()->map(function ($event) {
            $event->description = substr($event->description, 0, 50);
            return $event;
        });
        return response()->json($events, 200);
    }

    public function EventsByUser($request = "")
    {
        if (auth()->user() == null) {
            return response()->json('You are not logged in', 401);
        }
        DB::enableQueryLog();
        $userId = auth()->user()->id;
        $events = Event::select("categories.id as category_id", "categories.name", "events.*")
            ->where('user_id', $userId)
            ->where('events.deleted_at', null)
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->get();
        foreach ($events as $event) {
            $event->description = substr($event->description, 0, 60) . '...';
        }

        return response()->json($events, 200);
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
        $event->user_id = auth()->user()->id;
        $event->category_id = $request->category_id;
        $event->region_id = $request->region_id;
        if ($request->auto_approve) {
            $event->auto_approve = $request->auto_approve;
        }
        $event->save();
        return response()->json($event, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event = Event::where('events.id', $event->id)
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->join('users', 'events.user_id', '=', 'users.id')
            ->select('events.id as event_id', 'events.*', 'categories.name as category_name', 'users.name as user_name')
            ->first();

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

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
        $event->user_id = auth()->user()->id;
        $event->category_id = $request->category_id;
        $event->region_id = $request->region_id;
        if ($request->auto_approve === false) {
            $event->auto_approve = 0;
        } else {
            $event->auto_approve = 1;
        }
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

    public function validateEvent(Event $event)
    {
        if ($event->is_valid) {
            $event->is_valid = 0;
        } else {
            $event->is_valid = 1;
        }
        $event->save();
        return response()->json($event, 200);
    }
}
