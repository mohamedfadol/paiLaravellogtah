<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    protected $table = 'agendas';
    protected $guarded = ['id'];
    
    public function meeting() {
        return $this->belongsTo(Meeting::class);
    }
    
    public function agenda_details() {
        return $this->hasMany(AgendaDetails::class, 'agenda_id');
    }
    

}
