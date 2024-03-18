<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AnnualReport extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'annual_reports';
    protected $guarded = ['id'];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'annual_report_name' => 'string',
        'annual_report_file' => 'string',
        'annual_report_date' => 'datetime',
        'business_id' => 'integer',
        'meeting_id' => 'integer',
        'member_id' => 'integer',
        'add_by' => 'integer',
    ];
    
    public function business() {
        return $this->belongsTo(Business::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class, 'add_by');
    }
    
    
    public function meeting() {
        return $this->belongsTo(Meeting::class);
    }
    
    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_annual_report' , 'annual_report_id', 'member_id')->withPivot('annual_report_status','is_signed')->withTimestamps();
    }
}
