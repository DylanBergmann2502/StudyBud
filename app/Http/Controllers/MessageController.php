<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request, Room $room)
    {
        $validated = $request->validated();

        Message::create([
            'body' => $validated['body'],
            'user_id' => auth()->id(),
            'room_id' => $room->id
        ]);

        if (! $room->participants()->where('participant_id', auth()->id())->exists()) {
            $room->participants()->attach(auth()->user());
        }

        return redirect()->route('rooms.show', ['room' => $room->id])->with('message', 'Message created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
