<?php

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * The names of the tables.
     *
     * @var array
     */
    protected $tables = [
        'users', 'statuses', 'comments', 'status_user_likes', 'follows'
    ];

    /**
     * The names of the seeders.
     *
     * @var array
     */
    protected $seeders = [
        'UsersTableSeeder',
        'StatusesTableSeeder',
        'CommentsTableSeeder',
        'StatusUserLikesTableSeeder',
        'FollowsTableSeeder'
    ];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

        $this->cleanDatabase();

        foreach ($this->seeders as $seederClass)
        {
            $this->call($seederClass);
        }
	}

    /**
     * Clean out the database for each new seed generation.
     */
    private function cleanDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach ($this->tables as $table)
        {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
