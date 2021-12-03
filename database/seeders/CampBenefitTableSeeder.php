<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CampBenefit;

class CampBenefitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $campBenefits = [
            [
                'camp_id' => '1',
                'nama' => 'Offline Course Videos'
            ],
            [
                'camp_id' => '1',
                'nama' => 'Future Job Opportunity'
            ],
            [
                'camp_id' => '1',
                'nama' => '1-1 Mentoring class'
            ],
            [
                'camp_id' => '1',
                'nama' => 'Final Project certification'
            ],
            [
                'camp_id' => '1',
                'nama' => 'Premium Design Kit'
            ],
            [
                'camp_id' => '1',
                'nama' => 'Website Builder'
            ],


            [
                'camp_id' => '2',
                'nama' => 'Final Project Certification'
            ],
            [
                'camp_id' => '2',
                'nama' => 'Offline Course Videos'
            ],
            [
                'camp_id' => '2',
                'nama' => '1-1 Mentoring class '
            ]
        ];


        CampBenefit::insert($campBenefits);
    }
}
