<?php

namespace App\Http\Controllers;

use App\Company;
use App\TroubleTicket;
use Illuminate\Http\Request;

class StealController extends Controller
{
    public function steal(TroubleTicket $ticket)
    {
        $company     = Company::with('projects')->where('name', $ticket->company)->first();
        $projects    = $company->projects;

        return response()->json([
            'id'           => $ticket->id,
            'company_name' => $company->name,
            'company_id'   => $company->id,
            'projects'     => $projects,
        ]);
    }
}
