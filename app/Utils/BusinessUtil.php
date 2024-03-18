<?php

namespace App\Utils;

// use App\Unit;

// use App\User;
// use App\Account;
// use App\Barcode;
// use App\Contact;
// use App\Printer;
// use App\Business;
// use App\Currency;
// use App\AccountType;
// use App\InvoiceLayout;
// use App\InvoiceScheme;
// use App\BusinessLocation;
// use App\NotificationTemplate;
use App\Models\User;
use App\Models\Business;
use App\Models\Currency;
use App\Models\BusinessLocation;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class BusinessUtil extends Util
{

    /**
     * Adds a default settings/resources for a new business
     *
     * @param int $business_id
     * @param int $user_id
     *
     * @return boolean
     */
    public function newBusinessDefaultResources($business_id, $user_id)
    {
        $user = User::find($user_id);

        //create Admin role and assign to user
        $role = Role::create([ 'name' => 'Admin#' . $business_id,
                            'business_id' => $business_id,
                            'guard_name' => 'web', 'is_default' => 1
                        ]);
        $user->assignRole($role->name);

        return true;
    }

    // /**
    //  * Gives a list of all currencies
    //  *
    //  * @return array
    //  */
    public function allCurrencies()
    {
        $currencies = Currency::select('id', DB::raw("concat(country, ' - ',currency, '(', code, ') ') as info"))
                ->orderBy('country')
                ->pluck('info', 'id');

        return $currencies;
    }

    public function saudiArabia()
    {
        $SAR = Currency::select('id', DB::raw("concat(country, ' - ',currency, '(', code, ') ') as info"))->where('id',101)
                ->orderBy('country')
                ->pluck('info', 'id');

        return $SAR;
    }
    
    /**
     * Gives a list of all timezone
     *
     * @return array
     */
    public function allTimeZones()
    {
        $datetime = new \DateTimeZone("EDT");

        $timezones = $datetime->listIdentifiers();
        $timezone_list = [];
        foreach ($timezones as $timezone) {
            $timezone_list[$timezone] = $timezone;
        }

        return $timezone_list;
    }

    /**
     * Gives a list of all accouting methods
     *
     * @return array
     */
    public function allAccountingMethods()
    {
        return [
            'fifo' => __('business.fifo'),
            'lifo' => __('business.lifo')
        ];
    }

    /**
     * Creates new business with default settings.
     *
     * @return array
     */
    public function createNewBusiness($business_details)
    {
        $business_details['sell_price_tax'] = 'includes';

        $business_details['default_profit_percent'] = 25;

        //Add POS shortcuts
        $business_details['keyboard_shortcuts'] = '{"pos":{"express_checkout":"shift+e","pay_n_ckeckout":"shift+p","draft":"shift+d","cancel":"shift+c","edit_discount":"shift+i","edit_order_tax":"shift+t","add_payment_row":"shift+r","finalize_payment":"shift+f","recent_product_quantity":"f2","add_new_product":"f4"}}';


        //Add prefixes
        $business_details['ref_no_prefixes'] = [
            'purchase' => 'PO',
            'stock_transfer' => 'ST',
            'stock_adjustment' => 'SA',
            'sell_return' => 'CN',
            'expense' => 'EP',
            'contacts' => 'CO',
            'purchase_payment' => 'PP',
            'sell_payment' => 'SP',
            'business_location' => 'BL'
            ];

        //Disable inline tax editing
        $business_details['enable_inline_tax'] = 0;

        $business = Business::create_business($business_details);

        return $business;
    }

    /**
     * Gives details for a business
     *
     * @return object
     */
    public function getDetails($business_id)
    {
        $details = Business::
                        leftjoin('tax_rates AS TR', 'business.default_sales_tax', 'TR.id')
                        ->leftjoin('currencies AS cur', 'business.currency_id', 'cur.id')
                        ->select(
                            'business.*',
                            'cur.code as currency_code',
                            'cur.symbol as currency_symbol',
                            'thousand_separator',
                            'decimal_separator',
                            'TR.amount AS tax_calculation_amount',
                            'business.default_sales_discount'
                        )
                        ->where('business.id', $business_id)
                        ->first();

        return $details;
    }

    /**
     * Gives current financial year
     *
     * @return array
     */
    public function getCurrentFinancialYear($business_id)
    {
        $business = Business::where('id', $business_id)->first();
        $start_month = $business->fy_start_month;
        $end_month = $start_month -1;
        if ($start_month == 1) {
            $end_month = 12;
        }
        
        $start_year = date('Y');
        //if current month is less than start month change start year to last year
        if (date('n') < $start_month) {
            $start_year = $start_year - 1;
        }

        $end_year = date('Y');
        //if current month is greater than end month change end year to next year
        if (date('n') > $end_month) {
            $end_year = $start_year + 1;
        }
        $start_date = $start_year . '-' . str_pad($start_month, 2, 0, STR_PAD_LEFT) . '-01';
        $end_date = $end_year . '-' . str_pad($end_month, 2, 0, STR_PAD_LEFT) . '-01';
        $end_date = date('Y-m-t', strtotime($end_date));

        $output = [
                'start' => $start_date,
                'end' =>  $end_date
            ];
        return $output;
    }

    /**
     * Adds a new location to a business
     *
     * @param int $business_id
     * @param array $location_details
     * @param int $invoice_layout_id default null
     *
     * @return location object
     */
    public function addLocation($business_id, $location_details)
    {
         
        //Update reference count
        $ref_count = $this->setAndGetReferenceCount('business_location', $business_id);
        $location_id = $this->generateReferenceNumber('business_location', $ref_count, $business_id);

   
        $location = BusinessLocation::create(['business_id' => $business_id,
                            'name' => $location_details['name'],
                            'landmark' => $location_details['landmark']??'',
                            'city' => $location_details['city'],
                            'state' => $location_details['state'],
                            'zip_code' => $location_details['zip_code'],
                            'country' => $location_details['country'],  
                            'mobile' => !empty($location_details['mobile']) ? $location_details['mobile'] : '',
                            'alternate_number' => !empty($location_details['alternate_number']) ? $location_details['alternate_number'] : '',
                            'website' => !empty($location_details['website']) ? $location_details['website'] : '',
                            'email' => '',
                            'location_id' => $location_id, 
                        ]);
        return $location;
    }

    /**
     * Return the invoice layout details
     *
     * @param int $business_id
     * @param array $location_details
     * @param array $layout_id = null
     *
     * @return location object
     */
    // public function invoiceLayout($business_id, $location_id, $layout_id = null)
    // {
    //     $layout = null;
    //     if (!empty($layout_id)) {
    //         $layout = InvoiceLayout::find($layout_id);
    //     }
        
    //     //If layout is not found (deleted) then get the default layout for the business
    //     if (empty($layout)) {
    //         $layout = InvoiceLayout::where('business_id', $business_id)
    //                     ->where('is_default', 1)
    //                     ->first();
    //     }
    //     //$output = []
    //     return $layout;
    // }

    /**
     * Return the printer configuration
     *
     * @param int $business_id
     * @param int $printer_id
     *
     * @return array
     */
    // public function printerConfig($business_id, $printer_id)
    // {
    //     $printer = Printer::where('business_id', $business_id)
    //                 ->find($printer_id);

    //     $output = [];

    //     if (!empty($printer)) {
    //         $output['connection_type'] = $printer->connection_type;
    //         $output['capability_profile'] = $printer->capability_profile;
    //         $output['char_per_line'] = $printer->char_per_line;
    //         $output['ip_address'] = $printer->ip_address;
    //         $output['port'] = $printer->port;
    //         $output['path'] = $printer->path;
    //         $output['server_url'] = $printer->server_url;
    //     }

    //     return $output;
    // }

    /**
     * Return the date range for which editing of transaction for a business is allowed.
     *
     * @param int $business_id
     * @param char $edit_transaction_period
     *
     * @return array
     */
    // public function editTransactionDateRange($business_id, $edit_transaction_period)
    // {
    //     if (is_numeric($edit_transaction_period)) {
    //         return ['start' => \Carbon::today()
    //                             ->subDays($edit_transaction_period),
    //                 'end' => \Carbon::today()
    //             ];
    //     } elseif ($edit_transaction_period == 'fy') {
    //         //Editing allowed for current financial year
    //         return $this->getCurrentFinancialYear($business_id);
    //     }

    //     return false;
    // }

    /**
     * Return the default setting for the pos screen.
     *
     * @return array
     */
    public function defaultPosSettings()
    {
        return ['disable_pay_checkout' => 0, 'disable_draft' => 0, 'disable_express_checkout' => 0, 'hide_product_suggestion' => 0, 'hide_recent_trans' => 0, 'disable_discount' => 0, 'disable_order_tax' => 0, 'is_pos_subtotal_editable' => 0];
    }

    /**
     * Return the default setting for the email.
     *
     * @return array
     */
    public function defaultEmailSettings()
    {
        return ['mail_host' => '', 'mail_port' => '', 'mail_username' => '', 'mail_password' => '', 'mail_encryption' => '', 'mail_from_address' => '', 'mail_from_name' => ''];
    }

    /**
     * Return the default setting for the email.
     *
     * @return array
     */
    public function defaultSmsSettings()
    {
        return ['url' => '', 'send_to_param_name' => 'to', 'msg_param_name' => 'text', 'request_method' => 'post', 'param_1' => '', 'param_val_1' => '', 'param_2' => '', 'param_val_2' => '','param_3' => '', 'param_val_3' => '','param_4' => '', 'param_val_4' => '','param_5' => '', 'param_val_5' => '', ];
    }
}
