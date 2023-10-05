<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
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
        return view('users.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        auth()->login($user);

        return redirect()->route('home')->with('message', 'User created and logged in successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $topics = Topic::all()->take(5);
        $roomCount = Room::all()->count();
        $rooms = $user->hosted_rooms;
        $messages = $user->messages;

        return view('users.profile', [
            'user' => $user,
            'topics' => $topics,
            'rooms' => $rooms,
            'messages' => $messages,
            'roomCount' => $roomCount
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
