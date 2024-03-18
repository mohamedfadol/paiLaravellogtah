<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;
    protected $table = 'member_resolution';
    protected $guarded = ['id'];
    
    protected $casts = ['has_signed' => 'boolean'];
    
    public function member() {
        return $this->belongsTo(Member::class,'member_id');
    }
    
    public function resolution() {
        return $this->belongsTo(Resoultion::class,'resoultion_id');
    }
    
}
