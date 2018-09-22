<?php

use Illuminate\Database\Seeder;

class CampaignTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $rows = 20;

        for ($i=0; $i<$rows;$i++) {
            DB::table('campaigns_copy')->insert([
                'title' => $faker->realText($maxNbChars = 50),
                'id_user' => $faker->randomNumber(2),
                'description' => $faker->text(200),
                'count_donations' => $faker->randomNumber(5),
                'count_users' => $faker->randomNumber(5),
                'count_shares' => $faker->randomNumber(5),
                'target_donation' => $faker->randomNumber(8),
                'deadline' => date($format = 'Y-m-d'),
                'complete_sts' => $faker->randomNumber(1),
                'flag_active' => $faker->randomNumber(1),
                'campaign_link' => $faker->url,
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
                'created_by' => $faker->randomNumber(1),
                'updated_by' => $faker->randomNumber(1)
            ]);
        }

    }
}
