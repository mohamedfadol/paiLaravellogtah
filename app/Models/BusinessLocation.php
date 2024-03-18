<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessLocation extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'featured_products' => 'array'
    ];
    
    /**
     * Scope a query to only include active location.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }


    public function getLocationAddressAttribute() 
    {
        $location = $this;
        $address_line_1 = [];
        if (!empty($location->landmark)) {
            $address_line_1[] = $location->landmark;
        }
        if (!empty($location->city)) {
            $address_line_1[] = $location->city;
        }
        if (!empty($location->state)) {
            $address_line_1[] = $location->state;
        }
        if (!empty($location->zip_code)) {
            $address_line_1[] = $location->zip_code;
        }
        $address = implode(', ', $address_line_1);
        $address_line_2 = [];
        if (!empty($location->country)) {
            $address_line_2[] = $location->country;
        }
        $address .= '<br>';
        $address .= implode(', ', $address_line_2);

        return $address;
    }
}
