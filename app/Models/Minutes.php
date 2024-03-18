<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Minutes extends Model
{
    use HasFactory;
    protected $table = 'minutes';
    protected $guarded = ['id'];
    
    protected $casts = [
        'minute_date' => 'datetime',
        'committee_id' => 'integer',
        'board_id' => 'integer',
        'add_by' => 'integer',
        'meeting_id' => 'integer',
        'business_id' => 'integer',
    ];

     /**
     * Get the start time in a more readable format.
     */
    public function getMinuteDateAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d-m-Y g:i:s A');
    }

    
    /**
     * Get the start time in a more readable format.
     */
    // public function getCreatedAtAttribute($value)
    // {
    //     $date = Carbon::parse($value);
    //     return $date->format('d-m-Y g:i:s A');
    // }

    /**
     * Get the start time in a more readable format.
     */
    // public function getUpdatedAtAttribute($value)
    // {
    //     $date = Carbon::parse($value);
    //     return $date->format('d-m-Y g:i:s A');
    // }

    public function membersSignatures() {
        return $this->hasMany(MemberSignMinutes::class, 'minute_id');
    }
    
 
    
    public function signatures() {
        return $this->hasMany(MinuteSignature::class, 'minute_id');
    }
    
    public function attendance_boards() {
        return $this->hasMany(AttendanceBoard::class, 'minute_id');
    }
    
    public function business() {
        return $this->belongsTo(Business::class);
    }
    
    public function committee()
    {
        return $this->beLongsTo(Committee::class, 'committee_id');
    }

    public function board()
    {
        return $this->beLongsTo(Board::class, 'board_id');
    }
    
        
    public function user()
    {
        return $this->belongsTo(User::class, 'add_by');
    }
    
        
    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
}
