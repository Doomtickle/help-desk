<?php

namespace App\Http\Controllers;

use App\Task;
use App\Comment;
use App\Company;
use App\Project;
use App\TroubleTicket;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\TroubleTicket $ticket
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TroubleTicket $ticket, Request $request)
    {
        $this->validate($request, [
            'body'           => 'required',
            'task'           => 'required',
            'company'        => 'required',
            'project'        => 'required',
            'time_spent'     => 'required',
            'date_completed' => 'required'
        ]);


        $companyInfo = Company::where('id', $request->company)->first();
        $projectInfo = Project::where('id', $request->project)->first();
        $taskInfo = Task::where('id', $request->task)->first();

        $trouble_ticket_id = $ticket->id;
        $user_id = \Auth::user()->id;
        $company_id = $companyInfo->id;
        $company = $companyInfo->name;
        $company_beebole_id = $companyInfo->beebole_id;
        $project = $projectInfo->name;
        $project_beebole_id = $projectInfo->beebole_id;
        $task = $taskInfo->name;
        $task_id = $taskInfo->id;
        $task_beebole_id = $taskInfo->beebole_id; 
        $time_spent = $request->time_spent; 
        $date_completed = $request->date_completed;
        $body = $request->body;

        $comment = Comment::create(compact(
            'trouble_ticket_id', 
            'user_id', 
            'company_id', 
            'company', 
            'company_beebole_id', 
            'project', 
            'project_beebole_id', 
            'task', 
            'task_id', 
            'task_beebole_id', 
            'time_spent', 
            'date_completed',
            'body'
            )); 


       Comment::sendToBeebole($comment);
        
       return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
