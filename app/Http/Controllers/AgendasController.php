<?php

namespace App\Http\Controllers;

use App\Agenda;
use Illuminate\Http\Request;

class AgendasController extends Controller
{
    public function create()
    {
        return view('agendas.create');
    }

    public function store(Request $request) 
    {
       $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required'
        ]); 

       Agenda::create([
        'start_date' => $request->start_date, 
        'end_date' => $request->end_date 
        ]);

       return back();
    }
}
