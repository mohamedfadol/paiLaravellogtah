<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Searchable extends Model
{
    use HasFactory;
    protected $table = 'searchables';
    protected $guarded = ['id'];
}
