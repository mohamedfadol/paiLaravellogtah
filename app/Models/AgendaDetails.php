<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaDetails extends Model
{
    use HasFactory;
    
    protected $table = 'agenda_details';
    protected $guarded = ['id'];
    
    public function agenda() {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }
    
        public function actions() {
        return $this->belongsTo(ActionTracker::class, 'agenda_detail_id');
    }
}
