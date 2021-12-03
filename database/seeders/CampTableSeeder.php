<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\camps;

class CampTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $camps = [
            [
                'title' => 'Maniac Belajar',
                'slug' => 'maniac-belajar',
                'price' => 300,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time())

            ],
            [
                'title' => 'Baru Belajar',
                'slug' => 'baru-belajar',
                'price' => 150,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time())

            ]
        ];

        // //1st method
        // foreach ($camps as $key => $camp) {
        //     camps::create($camp);

        // }


        //2nd method
        camps::insert($camps);
    }
}
