<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PackageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [
            // business route
            ['name' => '1.Board ','price' => '33.300', 'description' => 'A.Committees,B.Minutes,C.Resolution,D.my notes,E.Action Tracker'],
            ['name' => '2.Governance ','price' => '73.366 ','description' => 'A.Legal,B.Contracts,C.Litigations,D.POA,E.Internal Consultations'],
            ['name' => '3.Company Information ','price' => '178.577','description' => 'A.Entities,B.DOA,C.Audit,D.Risk Management,E.Compliance,F.ESG Report'],
        ];

        DB::table('packages')->insert($packages);
    }
}
