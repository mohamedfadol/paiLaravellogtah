<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disclosure extends Model
{
    use HasFactory;
    protected $table = 'disclosures';
    protected $guarded = ['id'];
     
    public function business() {
        return $this->belongsTo(Business::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class, 'add_by');
    }
    
    public function member() {
        return $this->belongsTo(Member::class);
    }
}
