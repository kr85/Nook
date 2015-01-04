<?php

use Faker\Factory as Faker;
use Nook\Users\User;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the seeder for the users table.
     */
    public function run()
    {
        $faker = Faker::create();

        foreach(range(1, 50) as $index)
        {
            User::create([
                'username' => $faker->word . $index,
                'email' => $faker->email,
                'password' => 'secret'
            ]);
        }
    }
}