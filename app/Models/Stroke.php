<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stroke extends Model
{
    use HasFactory;
    protected $table = 'strokes';
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class, 'addby');
    }

    public function agenda() {
        return $this->belongsTo(Agenda::class, 'agenda_id');
    }
    
    public function getPointsAttribute($value)
    {
        return json_decode($value ?: [], true); //"$value ?: []" ensure a null value will be coverted into an empty array
    }
    
    public function getPositionAttribute($value)
    {
        return json_decode($value ?: [], true); //"$value ?: []" ensure a null value will be coverted into an empty array
    }
    
}
