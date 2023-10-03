<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Topic;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Requests\StoreTopicRoomRequest;
use App\Http\Requests\UpdateTopicRoomRequest;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $topics = Topic::all();

        return view('rooms.create', [
            'topics' => $topics
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTopicRoomRequest $request)
    {
        $validated = $request->validated();

        $topic = Topic::firstOrCreate([
            'name' => $validated['topic']
        ]);

        Room::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'topic_id' => $topic->id,
            'host_id' => auth()->id()
        ]);

        return redirect()->route('home')->with('message', ' Room created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return view('rooms.show', [
            'room' => $room,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $this->authorize('update', $room);

        $topics = Topic::all();

        return view('rooms.edit', [
            'room' => $room,
            'topics' => $topics
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTopicRoomRequest $request, Room $room)
    {
        $this->authorize('update', $room);

        $validated = $request->validated();

        $topic = Topic::firstOrCreate([
            'name' => $validated['topic']
        ]);

        $room->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'topic_id' => $topic->id,
            'host_id' => auth()->id()
        ]);

        return redirect()->route('rooms.show', ['room' => $room->id])->with('message', 'Room updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $this->authorize('delete', $room);

        $room->delete();

        return redirect()->route('home')->with('message', 'Room deleted successfully');
    }
}
