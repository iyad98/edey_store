<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\User;
use Illuminate\Support\Facades\DB;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i=0 ; $i < 50; $i++) {
            User::create([
                'name' => $faker->name,
                'username' => $faker->userName ,
                'phone' => $faker->randomNumber(9) ,
                'email' => 'test'.$i.'@gmail.com',
                'password' => bcrypt("123456"),
            ]);
			
        }

    }
}
