<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
 use Carbon\Carbon;

class Board extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'boards';
    protected $guarded = ['id'];
    
    protected $casts = [
        'term' => 'datetime',
        'fiscal_year' => 'datetime',
        'is_active' => 'boolean',
        'business_id' => 'integer', 
    ];

    public function scopeActive($query) {
        return $query->where('is_active', true)->first();
    }
    
    public function getTermAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function getFiscalYearAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }
    
    public function business() {
        return $this->belongsTo(Business::class);
    }

    /**
     * Get all of the meetings for the boards.
     */
    public function meetings() 
    {
        return $this->hasMany(Meeting::class,'board_id');
    }

    public function minutes()
    {
        return $this->hasMany(Minutes::class);
    }
    
    public function resoultions()
    {
        return $this->hasMany(Resoultion::class);
    }
    
    public function committees(){    
        return $this->hasMany(Committee::class);
    }

    public function members() {
        return $this->belongsToMany(Member::class, 'board_member')->withTimestamps();
    }
}
