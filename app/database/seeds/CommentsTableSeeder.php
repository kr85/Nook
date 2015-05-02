<?php

use Nook\Statuses\Comment;
use Nook\Users\User;
use Nook\Statuses\Status;
use Faker\Factory as Faker;

/**
 * Class CommentsTableSeeder
 */
class CommentsTableSeeder extends Seeder
{
    /**
     * Run the seeder for the comments table.
     */
	public function run()
	{
		$faker = Faker::create();
        $userIds = User::lists('id');
        $statusIds = Status::lists('id');

		foreach(range(1, 10000) as $index)
		{
			Comment::create([
                'status_id' => $faker->randomElement($statusIds),
                'user_id' => $faker->randomElement($userIds),
                'body' => $faker->sentence(),
                'created_at' => $faker->dateTimeThisYear()
			]);
		}
	}
}