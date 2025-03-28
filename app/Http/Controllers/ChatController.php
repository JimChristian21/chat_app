<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function get(Request $request, int $receiver_id)
    {
        return Inertia::render('Dashboard', [
            'user' => User::where('id', '=', $receiver_id),
            'messages' 
        ]);
    }
}
