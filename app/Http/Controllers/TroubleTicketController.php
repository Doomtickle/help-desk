<?php

namespace App\Http\Controllers;

use App\User;
use App\TroubleTicket;
use App\Utilities\Company;
use Illuminate\Http\Request;
use App\Notifications\TicketCreated;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\TroubleTicketController;

class TroubleTicketController extends Controller
{
    protected $user_id;
    protected $status;
    protected $complete;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = TroubleTicket::all();

        return view('troubletickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('troubletickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $admin = User::find(1);
        $troubleTicket     = TroubleTicket::create($request->all());
        $troubleTicket->user_id = \Auth::user()->id;
        $troubleTicket->save();

        $admin->notify(new TicketCreated($troubleTicket));

        return Redirect::to('/ticket/' . $troubleTicket->id);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     * @internal param TroubleTicket $ticket
     * @internal param int $id
     */
    public function show($id)
    {
        $tt        = TroubleTicket::ticketInfo($id);
        $companies = Company::all();

        return view('troubletickets.show', compact('tt', 'companies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = TroubleTicket::ticketInfo($id);
        return view('troubletickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TroubleTicket $ticket)
    {
        $ticket->update($request->all());
        if($ticket->status == 'Complete')
            $this->markComplete($ticket);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function markComplete(TroubleTicket $ticket)
    {
        $ticket->complete = true;
        $ticket->status   = 'Complete';
        $ticket->save();

        return back();

    }
    
}
