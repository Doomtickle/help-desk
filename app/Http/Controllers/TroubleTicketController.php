<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
use App\Project;
use Carbon\Carbon;
use App\SupportFile;
use App\TroubleTicket;
use Illuminate\Http\Request;
use App\Notifications\TicketCreated;
use App\Notifications\TicketUpdated;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\TroubleTicketRequest;
use App\Http\Controllers\TroubleTicketController;

class TroubleTicketController extends Controller
{
    
    protected $user_id;
    protected $status;
    protected $complete; 
    /**
     * __construct
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
            
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = TroubleTicket::with('supportingFiles', 'comments')->orderBy('created_at', 'desc')->get();

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
    public function store(TroubleTicketRequest $request)
    {
        $admin                  = User::find(1);
        $troubleTicket          = TroubleTicket::create($request->all());
        $troubleTicket->user_id = \Auth::user()->id;

        //Checks if a file was uploaded
        if($request->file('files')){

            $files = $request->file('files');
            $i = 0;
            foreach($files as $file){
                $name = $file[$i]->getClientOriginalName();
                $path = $file[$i]->store('SupportingDocs', 'public');

                
                $supportFile = SupportFile::create([
                                'trouble_ticket_id' => $troubleTicket->id,
                                'path' => $path,
                                'original_name' => $name,
                ]);

                $i++;
            }

        }

        $troubleTicket->save();


        $admin->notify(new TicketCreated($troubleTicket));

        return Redirect::to('/home');
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
        return view('troubletickets.show', compact('tt'));
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
     * @param  App\Http\Requests\TroubleTicketRequest $request
     * @param  App\TroubleTicket $Ticket
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TroubleTicketRequest $request, TroubleTicket $ticket)
    {
        foreach($request->all() as $key => $value){
            if($key === '_token' || $key === '_method') { continue; }
            $ticket->$key = $value;
            $changes = $ticket->changes();
        }
        if ($changes){
            $this->sendUpdateNotifications($ticket, $changes);
        }
        $ticket->updateStatus();
        $ticket->save();
        return redirect('/home');
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


    /**
     * Mark a ticket complete
     *
     * @param  App\TroubleTicket $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markComplete(TroubleTicket $ticket)
    {
        $changes = $ticket->markComplete();
        $this->sendUpdateNotifications($ticket, $changes);
        $ticket->save();



        $company     = Company::with('projects')->where('name', $ticket->company)->first();
        $projects    = $company->projects;


        return response()->json([
            'id'           => $ticket->id,
            'company_name' => $company->name,
            'company_id'   => $company->id,
            'projects'     => $projects,
        ]); 
    }

    /**
     * Sends a notification 
     * to the admins
     *
     * @param  App\TroubleTicket $ticket
     * @param  array $changes
     */
    public function sendUpdateNotifications(TroubleTicket $ticket, $changes)
    {
        $admin = User::find(1);

        foreach($changes as $key => $value){
            $changedItem = [$key => $value];
            $admin->notify(new TicketUpdated($ticket, $changedItem));
        }
    }
    
}
