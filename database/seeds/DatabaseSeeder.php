<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // $this->call(MedecinsTableSeeder::class);
    // $this->call(UsersTableSeeder::class);
    // $this->call(ReviewsTableSeeder::class);
     $this->call(AdminsTableSeeder::class);
  }
}
