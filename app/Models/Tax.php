<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;
    protected $table='taxes';
    protected $guarded = ['id'];

    public static function create_tax($details)
    {
        // dd($details);
        $package = Tax::create([
                    'name' => $details['tax_name'],
                    'amount' => $details['tax_amount'],
                    'business_id' => $details['business_id'],
                    'created_by' => $details['created_by'],
                ]);

        return $package;
    }
}
