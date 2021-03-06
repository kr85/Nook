<?php

use Nook\Users\User;
use Nook\Statuses\Status;
use Nook\Statuses\Like;
use Faker\Factory as Faker;

/**
 * Class StatusUserLikesTableSeeder
 */
class StatusUserLikesTableSeeder extends Seeder
{
    /**
     * Run the seeder for the status user likes table.
     */
	public function run()
	{
		$faker = Faker::create();
        $userIds = User::lists('id');
        $statusIds = Status::lists('id');

		foreach(range(1, 10000) as $index)
		{
			Like::create([
                'user_id' => $faker->randomElement($userIds),
                'status_id' => $faker->randomElement($statusIds),
                'created_at' => $faker->dateTimeThisYear()
			]);
		}
	}
}