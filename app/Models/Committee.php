<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use HasFactory;

    protected $table = 'committees';
    protected $guarded = ['id'];
    protected $casts = [
        'board_id' => 'integer',
        'business_id' => 'integer',
    ];

    /**
     * Get all of the meetings for the boards.
     */
    public function meetings() 
    {
        return $this->hasMany(Meeting::class);
    }
    

    public function resoultions()
    {
        return $this->hasMany(Resoultion::class);
    }
    
    public function minutes()
    {
        return $this->hasMany(Minutes::class);
    }
    

    public function board(){
        return $this->belongsTo(Board::class);
    }
    
    public function business(){
        return $this->belongsTo(Business::class);
    }

    public function members() {
        return $this->belongsToMany(Member::class, 'committee_member')->withTimestamps();
    }
}
