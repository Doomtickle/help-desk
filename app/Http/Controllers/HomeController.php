<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\TroubleTicket;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $tickets = TroubleTicket::orderBy('created_at', 'desc')->get();
        return view('adminlte::home', compact('tickets'));
    }

    public function beeboleKey(Request $request)
    {
        $this->validate($request, [
            'beebole_key' => 'required'
        ]);

        $user = \Auth::user();
        $key = $request->beebole_key;

        $user->beebole_key = $key;

        $user->save();

        return back();


    }
}
