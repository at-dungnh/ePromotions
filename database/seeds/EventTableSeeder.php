<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;


class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
      $users = User::all()->pluck('id');
      for($i = 0; $i < 10; $i++) {
        $created = $faker->dateTimeThisDecade($max = 'now');
        $updated = $faker->dateTimeThisDecade($max = 'now');
        $start = $faker->dateTimeThisMonth($min = 'now');
        $end = $faker->dateTimeThisMonth($min = 'now');
        if($created <= $updated && $start < $end) {
          DB::table('events')->insert([
              'title' => $faker->sentence($nbWords = 100, $variableNbWords = true),
              'description' => $faker->text($maxNbChars = 2000),
              'start_time' => $start,
              'end_time' => $end,
              'place' => $faker->address,
              'image' => 'event.jpg',
              'user_id' => $faker->randomElement($users->toArray()),
              'created_at' => $created,
              'updated_at' => $updated,
          ]);
        } else {
          $i--;
        }
      }
    }
}
