<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualAuditReport extends Model
{
    use HasFactory;
    protected $table = 'annual_audit_reports';
    protected $guarded = ['id'];
    
        /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'annual_audit_report_title' => 'string',
        'annual_audit_report_text' => 'string',
        'business_id' => 'integer',
        'created_by' => 'integer'
    ];
    
        
    public function business() {
        return $this->belongsTo(Business::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_annual_audit_report' , 'annual_audit_report_id', 'member_id')->withPivot('annual_audit_report_status','is_signed')->withTimestamps();
    }
}
