<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Business extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'businesses';

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
        'email_settings' => 'array',
        'sms_settings' => 'array',
        'common_settings' => 'array',
        'capital' => 'integer',
    ];

    /**
     * Returns the date formats
     */
    public static function date_formats()
    {
        return [
            'd-m-Y' => 'dd-mm-yyyy',
            'm-d-Y' => 'mm-dd-yyyy',
            'd/m/Y' => 'dd/mm/yyyy',
            'm/d/Y' => 'mm/dd/yyyy'
        ];
    }

    /**
     * Get the owner details
     */
    public function owner()
    {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    public function annual_audit_reports()
    {
        return $this->hasMany(AnnualAuditReport::class);
    }
    
    public function disclosures()
    {
        return $this->hasMany(Disclosure::class);
    }
    
    /**
     * Get the boards.
     */
    public function boards()
    {
        return $this->hasMany(Board::class);
    }
    
    /**
     * Get the annual_reports.
     */
    public function annual_reports()
    {
        return $this->hasMany(AnnualReport::class);
    }
    

    /**
     * Get the financials.
     */
    public function financials()
    {
        return $this->hasMany(Financial::class);
    }
    
    /**
     * Get the Business locations.
     */
    public function locations()
    {
        return $this->hasMany(BusinessLocation::class);
    }
 
    /**
     * Get the Business actions tracker.
     */
    public function actiontrackers()
    {
        return $this->hasMany(ActionTracker::class);
    }
    
    /**
    * Get the Business subscriptions.
    */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Creates a new business based on the input provided.
     *
     * @return object
     */
    public static function create_business($details)
    {
        $business = Business::create($details);
        return $business;
    }

    /**
     * Updates a business based on the input provided.
     * @param int $business_id
     * @param array $details
     *
     * @return object
     */
    public static function update_business($business_id, $details)
    {
        if (!empty($details)) {
            Business::where('id', $business_id)
                ->update($details);
        }
    }

    public function getBusinessAddressAttribute() 
    {
        $location = $this->locations->first();
        $address = $location->landmark . ', ' .$location->city . 
        ', ' . $location->state . '<br>' . $location->country . ', ' . $location->zip_code;

        return $address;
    }
}
