<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 */
class TroubleTicket extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'description',
        'priority',
        'status',
        'complete',
        'website',
    ];
    public function user()
    {
       return $this->belongsTo(User::class);     
    }

    public static function ticketInfo($id)
    {
        return static::where(compact('id'))->with('user')->first();

    }
    /**
     * Determine whether the ticket is complete and update the status accordingly
     *
     * @param TroubleTicket $ticket
     */
    public function updateStatus()
    {
        if($this->status == 'Complete')
            //ticket is complete
            return $this->markComplete();

        //ticket isn't complete so we'll mark it as such
        $this->complete = false;
        //save the ticket

    }
    /**
     * markComplete
     *
     * @param TroubleTicket $ticket
     */
    public function markComplete()
    {
        $this->complete = true;
        $this->status   = 'Complete';

    }
    
}
