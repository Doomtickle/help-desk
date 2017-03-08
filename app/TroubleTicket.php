<?php

namespace App;

use App\User;
use App\Notifications\TicketUpdated;
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
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function user()
    {
       return $this->belongsTo(User::class);     
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function supportingFiles()
    {
        return $this->hasMany(SupportFile::class);
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

        //remove the created_at timestamp if it exists
        if($this->completed_at)
            $this->completed_at = null;

    }
    /**
     * Mark the ticket complete
     *
     * @param TroubleTicket $ticket
     */
    public function markComplete()
    {
        $admin = User::find(1);

        $this->complete = true;
        $this->status   = 'Complete';
        $this->completed_at = \Carbon\Carbon::now();
        $changes = [
            'status' => 'Complete'
        ];

        return $changes;

    }

    /**
     * Determine if there are any changes and return the changed k/v pairs
     *
     * @return Array $changed
     */
    public function changes()
    {
        if($this->isDirty()){
            foreach($this->getDirty() as $column => $data)
                $changed[$column] = $data; 
            return $changed;
        }
    }
}
