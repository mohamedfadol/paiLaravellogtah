<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceBoard extends Model
{
    use HasFactory;
    protected $table = 'attendance_board';
    protected $guarded = ['id'];
    
    public function minute()
    {
        return $this->beLongsTo(Minutes::class, 'minute_id');
    }
}
