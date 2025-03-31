<?php

namespace App\Http\Controllers;

use App\Events\ChatUserBroadcast;
use App\Models\Message;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function get(Request $request, int $receiver_id)
    {
        return Inertia::render('Dashboard', [
            'users' => User::where('id', '!=', auth()->user()->id)->get(),
            'receiver' => User::where('id', '=', $receiver_id)->get()[0],
            'messages' => Message::where(function($query) use ($request, $receiver_id) {
                $query->where('sender_id', '=', $request->user()->id)
                    ->where('receiver_id', '=', $receiver_id);
            })->orWhere(function( Builder $query) use ($request, $receiver_id) {
                $query->where('sender_id', '=', $receiver_id)
                    ->where('receiver_id', '=', $request->user()->id);
            })->orderBy('created_at')
            ->get()
        ]);
    }

    public function store(Request $request, int $receiver_id)
    {
        $created_message = Message::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $receiver_id,
            'message' => $request->message
        ]);

        ChatUserBroadcast::dispatch($created_message);
        
        return Inertia::render('Dashboard', [
            'users' => User::where('id', '!=', auth()->user()->id)->get(),
            'receiver' => User::where('id', '=', $receiver_id)->get()[0],
            'messages' => (array) Message::where(function($query) use ($request, $receiver_id) {
                $query->where('sender_id', '=', $request->user()->id)
                    ->where('receiver_id', '=', $receiver_id);
            })->orWhere(function( Builder $query) use ($request, $receiver_id) {
                $query->where('sender_id', '=', $receiver_id)
                    ->where('receiver_id', '=', $request->user()->id);
            })->orderBy('created_at')
            ->get()
        ]);
    }
}
