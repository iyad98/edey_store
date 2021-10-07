<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Admin;
class AdminSeeder extends Seeder
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
            Admin::create([
                'admin_name' => $faker->name,
                'admin_username' => $faker->userName ,
                'admin_phone' => $faker->randomNumber(9) ,
                'admin_email' => 'test_admin'.$i.'@gmail.com',
                'password' => bcrypt("123456"),
                'admin_role' => \Illuminate\Support\Arr::random([1 , 2]) ,
                'admin_image' => get_default_image()
            ]);

        }
    }
}
