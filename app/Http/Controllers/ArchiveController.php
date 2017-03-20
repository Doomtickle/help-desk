<?php

namespace App\Http\Controllers;

use App\TroubleTicket;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index()
    {
        $tickets = TroubleTicket::where('archived', 1)->with('supportingFiles', 'comments')->get();
        return view('archive.index', compact('tickets'));
    }

    public function sendToArchive(TroubleTicket $ticket)
    {
        $ticket->archived = 1;
        $ticket->save();

        return back();
    }
}
