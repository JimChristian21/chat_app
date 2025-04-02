<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PeopleController extends Controller
{
    public function index() {
        return Inertia::render('People', [
            'users' => User::where('id', '!=', auth()->user()->id)->get()
        ]);
    }
}
