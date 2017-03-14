<?php

namespace App;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];


    /** 
     * A comment belongs to a User
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    /** 
     * A comment belongs to a trouble ticket
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function troubleTicket()
    {
        return $this->belongsTo(TroubleTicket::class);
    }

    public static function sendToBeebole(Comment $comment)
    {
       $beebole_key = \Auth::user()->beebole_key;
       $client = new Client();
       //since the API is wonky, we'll have to do a different call depending on whether or not the project has a subproject
       if($comment->subproject){
         $response = $client->post('https://beebole-apps.com/api/v2', [
             'auth' => [
                 $beebole_key,
                 'x',
                 'Basic'
             ],
              'json' => [
                  'service' => 'time_entry.create',
                  'subproject' => [
                     'id'   => $comment->subproject_beebole_id
                  ],
                  'task'    => [
                     'id'   => $comment->task_beebole_id
                  ],
                  'date'    => $comment->date_completed,
                  //casting to a float because who the hell knows why it goes through as a string...
                  'hours'   => (float) $comment->time_spent,
                  'comment' => $comment->body
              ]
         ]);
       }else{
         $response = $client->post('https://beebole-apps.com/api/v2', [
             'auth' => [
                 $beebole_key,
                 'x',
                 'Basic'
             ],
              'json' => [
                  'service' => 'time_entry.create',
                  'project' => [
                     'id'   => $comment->project_beebole_id
                  ],
                  'task'    => [
                     'id'   => $comment->task_beebole_id
                  ],
                  'date'    => $comment->date_completed,
                  //casting to a float because who the hell knows why it goes through as a string...
                  'hours'   => (float) $comment->time_spent,
                  'comment' => $comment->body
              ]
         ]);
       }

       $response = \GuzzleHttp\json_decode($response->getBody(), true);

       if($response['status'] == 'ok'){
          return redirect('/home')->with('beebole_success', 'Successfully logged to Beebole!');
       }

       return redirect('/home')->with('beebole_error', 'There was a problem logging your time to Beebole. You\'ll have to log it manually.');

 
    }
}
