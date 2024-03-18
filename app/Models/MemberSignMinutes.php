<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSignMinutes extends Model
{
    use HasFactory;
    protected $table = 'member_sign_minutes';
    protected $guarded = ['id'];
    
    protected $casts = ['has_signed' => 'boolean'];
    
    public function member() {
        return $this->belongsTo(Member::class,'member_id');
    }
    
    public function Minutes() {
        return $this->belongsTo(Minutes::class,'minute_id');
    }

}