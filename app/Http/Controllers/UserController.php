<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Muestra el dashboard del usuario.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('user.index');
    }

    public function listado()
    {
        return response()->json(User::all());
    }
}