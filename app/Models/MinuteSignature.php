<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinuteSignature extends Model
{
    use HasFactory;
    
    protected $table = 'member_minute';
    protected $guarded = ['id'];
    
    protected $casts = [
        'has_signed' => 'boolean',
        'minute_id' => 'integer',
        'member_id' => 'integer',
    ];
    
    public function member() {
        return $this->belongsTo(Member::class);
    }
    
    public function minute() {
        return $this->belongsTo(Minutes::class);
    }
}
