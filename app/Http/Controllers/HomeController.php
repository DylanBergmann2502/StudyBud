<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Topic;
use App\Models\Message;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $topics = Topic::all()->take(5);
        $rooms = Room::with('host', 'participants', 'topic')->latest()->filter(request(['q']))->get();
        $roomCount = Room::all()->count();
        $messages = Message::with('user', 'room')->take(5)->get();

        return view('core.index', [
            'topics' => $topics,
            'rooms' => $rooms,
            'roomCount' => $roomCount,
            'messages' => $messages,
        ]);
    }
}
