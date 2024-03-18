<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'employees';
    protected $guarded = ['id'];
    
    public function committees()
    {
        return $this->morphedByMany(Committee::class, 'morphable');
    }

    public function boards()
    {
        return $this->morphedByMany(Board::class, 'morphable');
    }
}
