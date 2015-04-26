<?php

use Faker\Factory as Faker;
use Nook\Statuses\Status;
use Nook\Users\User;

/**
 * Class StatusesTableSeeder
 */
class StatusesTableSeeder extends Seeder
{
    /**
     * Run the seeder for the statuses table.
     */
	public function run()
	{
		$faker = Faker::create();
        $userIds = User::lists('id');

		foreach(range(1, 1000) as $index)
		{
			Status::create([
                'user_id' => $faker->randomElement($userIds),
                'body' => $faker->sentence(),
                'image' => $faker->imageUrl($width = 536, $height = 450),
                'created_at' => $faker->dateTimeThisYear()
			]);
		}
	}

}