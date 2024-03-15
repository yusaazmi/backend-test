<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker;
use App\Models\Approver;
use App\Models\Status;

class ApproverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<3;$i++){
            $faker = Faker\Factory::create();
            $approver = new Approver;
            $approver->name = $faker->name;
            $approver->save();
        }
        $status = new Status;
        $status->name = 'menunggu persetujuan';
        $status->save();

        $status = new Status;
        $status->name = 'disetujui';
        $status->save();
    }
}
