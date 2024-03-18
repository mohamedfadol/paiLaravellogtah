<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PermissionsTableSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // business route
            ['name' => 'view_business','guard_name' => 'web'],
            ['name' => 'edit_business','guard_name' => 'web'],
            ['name' => 'activision_business','guard_name' => 'web'],
            ['name' => 'delete_business','guard_name' => 'web'],

            // taxs route
            ['name' => 'view_tax','guard_name' => 'web'],
            ['name' => 'new_tax','guard_name' => 'web'],
            ['name' => 'delete_tax','guard_name' => 'web'],
            ['name' => 'edit_tax','guard_name' => 'web'],

            // package route
            ['name' => 'view_package','guard_name' => 'web'],
            ['name' => 'new_package','guard_name' => 'web'],
            ['name' => 'delete_package','guard_name' => 'web'],
            ['name' => 'edit_package','guard_name' => 'web'],

            // user route
            ['name' => 'view_user','guard_name' => 'web'],
            ['name' => 'new_user','guard_name' => 'web'],
            ['name' => 'delete_user','guard_name' => 'web'],
            ['name' => 'edit_user','guard_name' => 'web'],
            ['name' => 'login_user','guard_name' => 'web'],

            // role route
            ['name' => 'view_role','guard_name' => 'web'],
            ['name' => 'new_role','guard_name' => 'web'],
            ['name' => 'delete_role','guard_name' => 'web'],
            ['name' => 'edit_role','guard_name' => 'web'],

            // subscription route
            ['name' => 'view_subscription','guard_name' => 'web'],
            ['name' => 'activision_subscription','guard_name' => 'web'],
            ['name' => 'delete_subscription','guard_name' => 'web'],
            ['name' => 'edit_subscription','guard_name' => 'web'],
            
            // api modules route
            ['name' => 'view_admin_module','guard_name' => 'web'],
            ['name' => 'view_charter','guard_name' => 'web'],
            ['name' => 'view_files','guard_name' => 'web'],
            ['name' => 'committee_amdin','guard_name' => 'web'],
            ['name' => 'audit_module','guard_name' => 'web'],
            ['name' => 'compliance_module','guard_name' => 'web'],
            ['name' => 'risk_module','guard_name' => 'web'],
            ['name' => 'legal_counsel_module','guard_name' => 'web'],
            ['name' => 'view_members','guard_name' => 'web'],
            ['name' => 'make_sign','guard_name' => 'web'],
            ['name' => 'make_comment','guard_name' => 'web'],
            ['name' => 'see_other_tracker','guard_name' => 'web'],
            ['name' => 'edit_members','guard_name' => 'web'],
            ['name' => 'delete_members','guard_name' => 'web'],
            ['name' => 'approve_members','guard_name' => 'web'],
            ['name' => 'add_members','guard_name' => 'web'],
            ['name' => 'add_board','guard_name' => 'web'],
            ['name' => 'edit_board','guard_name' => 'web'],
            ['name' => 'delete_board','guard_name' => 'web'],
            ['name' => 'view_boards','guard_name' => 'web'],
            
            ['name' => 'add_committee','guard_name' => 'web'],
            ['name' => 'edit_committee','guard_name' => 'web'],
            ['name' => 'delete_committee','guard_name' => 'web'],
            ['name' => 'view_committees','guard_name' => 'web'],
            
        ];

        DB::table('permissions')->insert($permissions);
        
        $positions = [
                        ['position_name' => 'Board Secretary','business_id' => '1'],
                        ['position_name' => 'Committee Secretary','business_id' => '1'],
                        ['position_name' => 'Internal Audit','business_id' => '1'],
                        ['position_name' => 'Compliance','business_id' => '1'],
                        ['position_name' => 'Risk Management','business_id' => '1'],
                        ['position_name' => 'Legal Counsel','business_id' => '1'],
                        ['position_name' => 'Board Member','business_id' => '1'],
                        ['position_name' => 'Committee Member','business_id' => '1'],
                        ['position_name' => 'Chairman','business_id' => '1'],
                        ['position_name' => 'Audit Committee Chairman','business_id' => '1'],
                        ['position_name' => 'NRC Committee Chairman','business_id' => '1'],
                        ['position_name' => 'Custom Chairman','business_id' => '1'],
                        ['position_name' => 'CEO','business_id' => '1'],
                        ['position_name' => 'CFO','business_id' => '1'],
                    ];
        DB::table('positions')->insert($positions);
    }
}
