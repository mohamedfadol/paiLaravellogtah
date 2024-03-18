<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;
    protected $table = 'criterias';
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // 'has_vote' => 'boolean',
        // 'criteria_degree' => 'integer',
    ];

    public function members() {
        return $this->belongsToMany(Member::class, 'member_criteria')->withPivot('criteria_degree','has_vote','elected_by')->withTimestamps();
    }
    
    public function business() {
        return $this->belongsTo(Business::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class,'created_by');
    }
}
