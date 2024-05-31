<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioNote extends Model
{
    use HasFactory;
    protected $table = 'audio_notes';
    protected $guarded = ['id'];
    
    public function user() {
        return $this->belongsTo(User::class, 'addby');
    }

    public function business() {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function agenda() {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }
    
    public function scopeByAuth($query, $minPrice)
    {
        return $query->where('addby', $minPrice);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_audio_note' , 'audio_note_id', 'member_id')->withTimestamps();
    }
    
}
