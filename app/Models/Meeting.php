<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\MeetingStatusEnum;
use Carbon\Carbon;
class Meeting extends Model
{
    use HasFactory;
    protected $table = 'meetings';
    protected $guarded = ['id'];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $appends = ['meeting_start_date','meeting_end_date'];
    protected $casts = [
        // 'meeting_status' => MeetingStatusEnum::class,
        'is_active' => 'boolean',
        'hasNextMeeting' => 'boolean',
        'meeting_start' => 'datetime',
        'meeting_end' => 'datetime',
        'created_by' => 'integer',
        'previous_meeting_id' => 'integer',
    ];
    
    // Define an accessor for 'meeting_start_date'
    public function setMeetingStartDateAttribute()
    {
        // Your logic here. For example:
        return $this->attributes['meeting_start'];
    }

    // Define an accessor for 'meeting_end_date'
    public function setMeetingEndDateAttribute()
    {
        // Your logic here. For example:
        return $this->attributes['meeting_end'];
    }

     /**
     * Get the start time in a more readable format.
     */
    public function getMeetingStartDateAttribute($value)
    {
        // Parse the datetime value
        $date = Carbon::parse($this->attributes['meeting_start']);
        // Return the date-time in the desired format
        // For example, 'g:i A' for 12-hour format with AM/PM
        // return $date->format('Y-m-d g:i:s A');
        return $date->format('d-m-Y g:i:s A');
    }

    // /**
    //  * Get the start time in a more readable format.
    //  */
    public function getMeetingEndDateAttribute($value)
    {
        $date = Carbon::parse($this->attributes['meeting_end']);
        return $date->format('d-m-Y g:i:s A');
    }

    /**
     * Get the start time in a more readable format.
     */
    public function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d-m-Y g:i:s A');
    }

    /**
     * Get the start time in a more readable format.
     */
    public function getUpdatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('d-m-Y g:i:s A');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($meeting) {
            $currentYear = now()->year;
            $business_id = $meeting->business_id;
            // Find the last meeting in the current year for this business
            $lastMeetingOfYear = Meeting::where('business_id', $business_id)
                                        ->whereYear('created_at', $currentYear)
                                        ->orderBy('meeting_serial_number', 'desc')
                                        ->first();
            if ($lastMeetingOfYear) {
                // Extract the numeric part of the serial number and increment it
                $lastSerialNumber = (int) substr($lastMeetingOfYear->meeting_serial_number, strpos($lastMeetingOfYear->meeting_serial_number, '/') + 1);
                $newSerialNumber = $lastSerialNumber + 1;
            } else {
                // If there are no meetings in the current year, start with 01
                $newSerialNumber = 1;
            }
            // Format the new meeting_serial_number as Year/SerialNumber
            $meeting->meeting_serial_number = sprintf('%d/%02d', $currentYear, $newSerialNumber);
        });
    }


    public function business() {
        return $this->belongsTo(Business::class);
    }
    
    /**
     * Get the annual_reports.
     */
    public function annual_reports()
    {
        return $this->hasMany(AnnualReport::class);
    }
    
    /**
     * Get the financials. 
     */
    public function financials()
    {
        return $this->hasMany(Financial::class);
    }
    
    public function agendas() {
        return $this->hasMany(Agenda::class);
    }
    
    public function attendances() {
        return $this->belongsToMany(Member::class, 'meeting_attendance')->withPivot('is_attended')->withTimestamps();
    }
      
    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }

    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function minute()
    {
        return $this->hasMany(Minutes::class);
    }
    
    public function actions()
    {
        return $this->hasMany(ActionTracker::class);
    }
}
