<?php

namespace App\Http\Controllers;

use App\Task;
use App\Company;
use App\Project;
use Carbon\Carbon;
use App\Subproject;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BeeBoleController extends Controller
{

    public function seedCompanies()
    {
       $client = new Client();
       $beebole_key = \Auth::user()->beebole_key;

       $response = $client->post('https://beebole-apps.com/api/v2', [
           'auth' => [
               $beebole_key,
               'x',
               'Basic'
           ],
            'json' => [
                'service' => 'company.list',
            ]
       ]);

       $response = \GuzzleHttp\json_decode($response->getBody(), true);
       $companies = $response['companies'];


       foreach($companies as $company){
	       	if($company['active']){
	           Company::updateOrCreate([ 'beebole_id' => $company['id']], [
              'name'       => $company['name'],
              'beebole_id' => $company['id'],
              'status'     => 'active'
              ]);
	       	}
       }


        return back();
    }

    public function seedProjects()
    {
       $client = new Client();
       $beebole_key = \Auth::user()->beebole_key;

       $companies = Company::where('status', 'active')->get();
       foreach($companies as $company){
           $response = $client->post('https://beebole-apps.com/api/v2', [
               'auth' => [
                   $beebole_key,
                   'x',
                   'Basic'
               ],
                'json' => [
                    'service' => 'project.list',
                    'company' => [
                        'id' => $company->beebole_id 
                    ],
                ]
           ]);

           $response = \GuzzleHttp\json_decode($response->getBody(), true);
           $projects = $response['projects'];

           $projectsArray = [];

           foreach($projects as $project){
               Project::updateOrCreate([ 'beebole_id' => $project['id']],[ 
                'name'        => $project['name'],
                'beebole_id'  => $project['id'],
                'company_id'  => $company->id,
                'subprojects' => $project['subprojects']['count']
                ]);
           }
    }

        return back();

    }
    public function seedTasks()
    {
       $client = new Client();
       $beebole_key = \Auth::user()->beebole_key;

       $company = Company::find(105);
       $response = $client->post('https://beebole-apps.com/api/v2', [
           'auth' => [
               $beebole_key,
               'x',
               'Basic'
           ],
            'json' => [
                'service' => 'task.list',
                'company' =>[
                    'id' => $company->beebole_id 
                ]
            ]
       ]);

       $response = \GuzzleHttp\json_decode($response->getBody(), true);
       $tasks = $response['tasks'];

       foreach($tasks as $task){

            Task::updateOrCreate([

                'name'       => $task['name'],
                'beebole_id' => $task['beebole_id'],

            ]);

       }

        return back();


    }

    public function seedSubprojects()
    {

       $client = new Client();
       $beebole_key = \Auth::user()->beebole_key;

       $projects = Project::with('company')->where('subprojects', '>', '0')->get();

       foreach($projects as $project){
       $response = $client->post('https://beebole-apps.com/api/v2', [
           'auth' => [
               $beebole_key,
               'x',
               'Basic'
           ],
            'json' => [
                'service' => 'subproject.list',
                'project' => [
                    'id'  => $project->beebole_id
                ],
            ]
       ]);


       $response = \GuzzleHttp\json_decode($response->getBody(), true);
       $subprojects = $response['subprojects'];

      foreach($subprojects as $subproject){

        if($subproject['active']){
          Subproject::updateOrCreate([ 
            'name'       => $subproject['name']], [
            'name'       => $subproject['name'],
            'beebole_id' => $subproject['id'], 
            'project_id' => $project->id, 
            'company_id' => $project->company->id 
          ]);
          }
       }

    }

        return back();

    }
    public function getSubprojects($id)
    {

      $subprojects = Subproject::where('project_id', $id)->get();

      return response()->json([
          'subprojects' => $subprojects
      ]); 

    }

}
