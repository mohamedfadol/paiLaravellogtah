<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanvasItem extends Model
{
    use HasFactory;

    protected $table = 'canvas_items';
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

    public function strokes() {
        return $this->hasMany(Stroke::class, 'canvas_item_id');
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_pen_note' , 'canva_item_id', 'member_id')->withTimestamps();
    }
}
