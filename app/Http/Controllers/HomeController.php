<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Topic;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $topics = Topic::all()->take(5);
        $rooms = Room::with('host', 'participants', 'topic')->get();

        return view('core.index', [
            'topics' => $topics,
            'rooms' => $rooms
        ]);
    }
}
