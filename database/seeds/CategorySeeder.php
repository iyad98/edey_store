<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i=0 ; $i <= 20 ; $i++) {
            \App\Models\Category::create([
                'name_en' => $faker->name ,
                'name_ar' => $faker->name ,
                'description_en' => $faker->sentence ,
                'description_ar' => $faker->sentence ,
                'type' => random_int(1 , 2) ,
                'parent' => null ,
                'image' => get_general_path_default_image('categories')

            ]);
        }
    }
}
