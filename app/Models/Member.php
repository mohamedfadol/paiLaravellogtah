<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory,SoftDeletes,HasRoles;

    protected $table = 'members';
    protected $guarded = ['id'];
    protected $guard_name = 'web';

    /**
     * The attributes that should be cast.
     *
     * @var array
    */
    protected $casts = [
        'is_active' => 'boolean',
        'has_vote' => 'boolean',
        'business_id' => 'integer',
    ];

    
    public function annual_audit_reports()
    {
        return $this->belongsToMany(AnnualAuditReport::class, 'member_annual_audit_report' , 'member_id', 'annual_audit_report_id')->withPivot('annual_audit_report_status','is_signed')->withTimestamps();
    }
    
    /**
     * Get the annual_reports.
    */
    public function annual_reports()
    {
        return $this->belongsToMany(AnnualReport::class, 'member_annual_report' , 'member_id' , 'annual_report_id')->withPivot('annual_report_status','is_signed')->withTimestamps();
    }
    
    public function financials()
    {
        return $this->belongsToMany(Financial::class, 'member_financial' , 'member_id', 'financial_id')->withPivot('financial_status','is_signed')->withTimestamps();
    }
    
    public function actions()
    {
        return $this->hasMany(ActionTracker::class);
    }
             
    public function criterias() {
        return $this->belongsToMany(Criteria::class, 'member_criteria')->withPivot('criteria_degree','has_vote','elected_by')->withTimestamps();
    }
    
   public function resolutions() {
        return $this->belongsToMany(Resoultion::class,'member_resolution')->withPivot('has_signed')->withTimestamps();
    }
        
    public function attendances() {
        return $this->belongsToMany(Meeting::class, 'meeting_attendance')->withPivot('is_attended')->withTimestamps();
    }
    
    public function minute_signature_member() {
        return $this->hasOne(MemberSignMinutes::class, 'member_id');
    }
    
    public function signature_member() {
        return $this->hasOne(Signature::class, 'member_id');
    }
    
    
    public function minute_signature() {
        return $this->hasOne(MinuteSignature::class, 'member_id');
    }
    
    public function committees() {
        return $this->belongsToMany(Committee::class, 'committee_member')->withTimestamps();
    }

    public function boards() {
        return $this->belongsToMany(Board::class, 'board_member')->withTimestamps();
    }

    public function position() {
        return $this->belongsTo(Position::class);
    }

    public function disclosures()
    {
        return $this->hasMany(Disclosure::class);
    }
    
    // public function notes()
    // {
    //     return $this->hasMany(Note::class);
    // }

    public function notes()
    {
        return $this->belongsToMany(Note::class);
    }

    public function audio_notes()
    {
        return $this->belongsToMany(AudioNote::class, 'member_audio_note' , 'member_id', 'audio_note_id')->withTimestamps();
    }

    public function canva_items()
    {
        return $this->belongsToMany(CanvasItem::class,'member_pen_note' ,  'member_id', 'canva_item_id')->withTimestamps();
    }

    /**
     * Creates a new member based on the input provided.
     *
     * @return object
     */
    public static function create_user_member($details)
    {
        $member = Member::create([
                "member_first_name" =>  $details['member_first_name'],
                "member_middel_name" => $details['member_middel_name'],
                "member_last_name" =>  $details['member_last_name'],
                "member_email" =>  $details['member_email'],
                "is_active" =>  $details['is_active']  == 1 ? true : false,
                "has_vote" =>  $details['has_vote']  == 1 ? true : false,
                "business_id" =>  $details['business_id'],
                "position_id" => $details['position_id'],
                "member_password" => Hash::make($details['member_password'])?? null,
                "member_profile_image" =>  $details['member_profile_image'] ? $details['member_profile_image'] : null,
                "member_biography" =>  $details['member_biography'] ? $details['member_biography'] : null,
                ]);

        return $member;
    }
    
    
    /**
     * Creates a new member based on the input provided.
     *
     * @return object
     */
     
    public static function create_admin_member($details){
        $member = Member::create([
                    'member_first_name' => $details['first_name'],
                    'member_middel_name' => $details['last_name'],
                    'member_email' => $details['email'],
                    'name_password' => $details['password'],
                    'member_password' => Hash::make($details['password']),
                    'member_type' => "owner",
                    'position_id' => $details['position_id'],
                    'created_by' => $details['created_by'],
                    'business_id' => $details['business_id']
                ]);

        return $member;
    }
    
    
}
