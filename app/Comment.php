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
       $client = new Client();
       $response = $client->post('https://beebole-apps.com/api/v2', [
           'auth' => [
               '35b8fe932e158eabc89d1e5f8c8e898b48393f90',
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
                'date'    => '2017-03-13',
                'hours'   => (float) $comment->time_spent,
                'comment' => $comment->body
            ]
       ]);

       $response = \GuzzleHttp\json_decode($response->getBody(), true);

       dd($response);



 
    }
}
