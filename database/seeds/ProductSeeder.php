<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $categories = \App\Models\Category::select('*')->pluck('id')->toArray();
        $brands = \App\Models\Brand::select('*')->pluck('id')->toArray();
        $attributes = \App\Models\Attribute::whereHas('attribute_values')->select('*')->pluck('id')->toArray();


        for ($i = 3; $i < 20; $i++) {
            $product = \App\Models\Product::create([
                'name_en' => $faker->name,
                'name_ar' => $faker->name,
                'description_en' => $faker->sentence,
                'description_ar' => $faker->sentence,
                'image' => get_default_image(),
                'is_variation' => 0,
                'brand_id' => \Illuminate\Support\Arr::random($brands),
                'min_price' => null,
                'max_price' => null
            ]);
            $product->categories()->sync(\Illuminate\Support\Arr::random($categories));

            $attribute_id = \Illuminate\Support\Arr::random($attributes);
            $product_attribute = \App\Models\ProductAttribute::create([
                'product_id' => $product->id ,
                'attribute_id' => $attribute_id,
                'is_variation' => 0
            ]);

            $attribute_value = \App\Models\AttributeValue::where('attribute_id' , '=' ,$attribute_id)->pluck('id')->toArray();
            \App\Models\ProductAttributeValue::create([
                'product_attribute_id' => $product_attribute->id,
                'attribute_value_id' => \Illuminate\Support\Arr::random($attribute_value)
            ]);

            $product_variation = $product->variation()->create([
                'key' => '*',
                'description_en' => $faker->sentence,
                'description_ar' => $faker->sentence,
                'regular_price' => 40,
                'discount_price' => 0,
                'on_sale' => 1,
                'min_quantity' => 1,
                'max_quantity' => 1000,
                'sku' => 'Hys' . $i,
                'stock_management_status' => 1,
                'stock_status_id' => 1,
                'stock_quantity' => 1000,
                'remain_product_count_in_low_stock' => 2,
                'is_default_select' => 1
            ]);

        }

        for ($i = 22; $i < 30; $i++) {
            $product = \App\Models\Product::create([
                'name_en' => $faker->name,
                'name_ar' => $faker->name,
                'description_en' => $faker->sentence,
                'description_ar' => $faker->sentence,
                'image' => get_default_image(),
                'is_variation' => 0,
                'brand_id' => \Illuminate\Support\Arr::random($brands),
                'min_price' => null,
                'max_price' => null
            ]);
            $product->categories()->sync(\Illuminate\Support\Arr::random($categories));

            $attribute_id = \Illuminate\Support\Arr::random($attributes);
            $product_attribute = \App\Models\ProductAttribute::create([
                'product_id' => $product->id ,
                'attribute_id' => $attribute_id,
                'is_variation' => 0
            ]);

            $attribute_value = \App\Models\AttributeValue::where('attribute_id' , '=' ,$attribute_id)->pluck('id')->toArray();
            \App\Models\ProductAttributeValue::create([
                'product_attribute_id' => $product_attribute->id,
                'attribute_value_id' => \Illuminate\Support\Arr::random($attribute_value)
            ]);

            $product_variation = $product->variation()->create([
                'key' => '*',
                'description_en' => $faker->sentence,
                'description_ar' => $faker->sentence,
                'regular_price' => rand(30 , 150),
                'discount_price' => rand(5 , 20),
                'on_sale' => 1,
                'min_quantity' => 1,
                'max_quantity' => 1000,
                'sku' => 'Hys' . $i,
                'stock_management_status' => 1,
                'stock_status_id' => 1,
                'stock_quantity' => 1000,
                'remain_product_count_in_low_stock' => 2,
                'is_default_select' => 1
            ]);

        }
    }
}
