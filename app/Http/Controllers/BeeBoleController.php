<?php

namespace App\Http\Controllers;

use App\Task;
use App\Company;
use App\Project;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BeeBoleController extends Controller
{
    public function listCompanies()
    {
       $client = new Client();

       $response = $client->post('https://beebole-apps.com/api/v2', [
           'auth' => [
               '35b8fe932e158eabc89d1e5f8c8e898b48393f90',
               'x',
               'Basic'
           ],
//           'json' => [
//               'service' => 'time_entry.create',
//               'subproject' => [
//                   'id' => 37
//               ],
//               'task' => [
//                   'id' => 1
//               ],
//               'date' => '2017-01-20',
//               'hours' => 8,
//               'comment' => 'test comment'
//           ]
            'json' => [
                'service' => 'company.list',
            ]
       ]);

       $response = \GuzzleHttp\json_decode($response->getBody(), true);
       $companies = $response['companies'];

       $companiesArray = [];

       foreach($companies as $company){
           array_push($companiesArray, array('name' => $company['name'], 'beebole_id' => $company['id']));
       }

       sort($companiesArray);

       foreach($companiesArray as $company){
            Company::create(['name' => $company['name'],
                           'beebole_id' => $company['beebole_id'],
             ]);

       }

        return back();
    }

    public function updateProjects()
    {
       $client = new Client();

       $companies = Company::all();
       foreach($companies as $company){
           $response = $client->post('https://beebole-apps.com/api/v2', [
               'auth' => [
                   '35b8fe932e158eabc89d1e5f8c8e898b48393f90',
                   'x',
                   'Basic'
               ],
    //           'json' => [
    //               'service' => 'time_entry.create',
    //               'subproject' => [
    //                   'id' => 37
    //               ],
    //               'task' => [
    //                   'id' => 1
    //               ],
    //               'date' => '2017-01-20',
    //               'hours' => 8,
    //               'comment' => 'test comment'
    //           ]
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
               array_push($projectsArray, array('name' => $project['name'], 'beebole_id' => $project['id']));
           }

           sort($projectsArray);

           foreach($projectsArray as $project){
                Project::create([

                    'name' => $project['name'], 
                    'beebole_id' => $project['beebole_id'], 
                    'company_id' => $company->id ]);

           }
       }

        return back();

    }
    public function updateTasks()
    {
       $client = new Client();

       $company = Company::find(105);
       $response = $client->post('https://beebole-apps.com/api/v2', [
           'auth' => [
               '35b8fe932e158eabc89d1e5f8c8e898b48393f90',
               'x',
               'Basic'
           ],
//           'json' => [
//               'service' => 'time_entry.create',
//               'subproject' => [
//                   'id' => 37
//               ],
//               'task' => [
//                   'id' => 1
//               ],
//               'date' => '2017-01-20',
//               'hours' => 8,
//               'comment' => 'test comment'
//           ]
            'json' => [
                'service' => 'task.list',
                'company' =>[
                    'id' => $company->beebole_id 
                ]
            ]
       ]);

       $response = \GuzzleHttp\json_decode($response->getBody(), true);
       $tasks = $response['tasks'];

       $tasksArray = [];

       foreach($tasks as $task){
           array_push($tasksArray, array('name' => $task['name'], 'beebole_id' => $task['id']));
       }

       sort($tasksArray);

       foreach($tasksArray as $task){

            Task::create([

                'name' => $task['name'], 
                'beebole_id' => $task['beebole_id'], 

            ]);

       }

        return back();


    }

}
