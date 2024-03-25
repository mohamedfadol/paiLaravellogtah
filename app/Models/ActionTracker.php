<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\ActionTrackerStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActionTracker extends Model
{
    use HasFactory ,SoftDeletes;
    protected $table = 'action_trackers';
    protected $guarded = ['id'];
    
        /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // 'action_status' => ActionTrackerStatusEnum::class,
        'member_id' => 'integer',
        'tasks' => 'string',
        'date_due' => 'datetime',
        'date_assigned' => 'datetime',
        'meeting_id' => 'integer',
        'agenda_detail_id' => 'integer',
        'business_id'=> 'integer',
        'note' => 'string',
    ];
    
        /**
     * Get the start time in a more readable format.
     */
    public function getDateDueAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d-m-Y g:i:s A');
    }

    /**
     * Get the start time in a more readable format.
     */
    public function getDateAssignedAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d-m-Y g:i:s A');
    }


    // /**
    //  * Get the start time in a more readable format.
    //  */
    // public function getCreatedAtAttribute($value)
    // {
    //     $date = Carbon::parse($value);
    //     return $date->format('d-m-Y g:i:s A');
    // }

    // /**
    //  * Get the start time in a more readable format.
    //  */
    // public function getUpdatedAtAttribute($value)
    // {
    //     $date = Carbon::parse($value);
    //     return $date->format('d-m-Y g:i:s A');
    // }

    public function business() {
        return $this->belongsTo(Business::class);
    }
    
    public function member() {
        return $this->belongsTo(Member::class);
    }
    
    public function meeting() {
        return $this->belongsTo(Meeting::class);
    }
    
    public function details() {
        return $this->belongsTo(AgendaDetails::class,'agenda_detail_id');
    }
}
