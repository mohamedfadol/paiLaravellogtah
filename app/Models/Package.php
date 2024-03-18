<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    // protected $fillable = [];
    
    protected $guarded = ['id'];

    protected $casts = [
        'custom_permissions' => 'array',
    ];
    
    /**
     * Scope a query to only include active packages.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Returns the list of active pakages
     *
     * @return object
     */
    public static function listPackages($exlude_private = false)
    {
        $packages = Package::active()
                        ->orderby('sort_order');

        if ($exlude_private) {
            $packages->notPrivate();
        }

        return $packages->get();
    }

        /**
     * Creates a new user based on the input provided.
     *
     * @return object
     */
    public static function create_package($details)
    {
        // dd($details);
        $package = Package::create([
                    'name' => $details['package_name'],
                    'description' => $details['description'],
                    'price' => $details['price'],
                    'trial_days' => $details['package_trial_days'],
                    'is_active' => !empty($details['is_active'])? $details['is_active'] : 0,
                    'is_one_time' => !empty($details['is_one_time'])? $details['is_one_time'] : 0,
                    'is_private' => !empty($details['is_private'])? $details['is_private'] : 0,
                    'interval' => $details['interval'],
                ]);

        return $package;
    }

    /**
     * Scope a query to exclude private packages.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotPrivate($query)
    {
        return $query->where('is_private', 0);
    }
}
