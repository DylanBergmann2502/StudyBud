<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $topics = Topic::all()->take(5);

        return view('core.index', [
            'topics' => $topics,
        ]);
    }
}
