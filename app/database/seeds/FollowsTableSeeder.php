<?php

use Nook\Users\User;
use Nook\Users\Follow;
use Faker\Factory as Faker;

/**
 * Class FollowsTableSeeder
 */
class FollowsTableSeeder extends Seeder
{
    /**
     * Run the seeder for the follows table.
     */
	public function run()
	{
		$faker = Faker::create();
        $userIds = User::lists('id');

		foreach(range(1, 1000) as $index)
		{
			Follow::create([
                'follower_id' => $faker->randomElement($userIds),
                'followed_id' => $faker->randomElement($userIds),
                'created_at' => $faker->dateTimeThisYear()
			]);
		}
	}
}