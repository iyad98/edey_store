<?php

namespace App\Imports;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ProductImport implements ToCollection , WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection  $rows)
    {


        foreach ($rows as $row)
        {

            if ($row['rkm_almntj'] == null){

                $categories =  explode(',' , isset($row['altsnyfat']) ? $row['altsnyfat'] : '' );
                $categories_id = Category::whereIn('name_ar',array_map('trim', $categories))->pluck('id');

                $product = Product::find( $row['almaarf']);
                $product->image = isset($row['sorh_almntj']) ? 'products/'.$row['sorh_almntj'] : '' ;

                $product->name_ar = isset($row['alasm']) ? $row['alasm'] : 'd' ;
                $product->name_en = isset($row['alasm']) ? $row['alasm'] : 'd' ;

                $product->description_en = isset($row['alosf']) ? $row['alosf'] : '' ;
                $product->description_ar = isset($row['alosf']) ? $row['alosf'] : '' ;

                $product->is_variation = 1;
                $product->can_returned =isset($row['amkanyh_alastrjaaa']) ? $row['amkanyh_alastrjaaa'] : 0 ;
                $product->can_gift =isset($row['amkanyh_alastrjaaa']) ? $row['amkanyh_alastrjaaa'] : 0;
                $product->save();
                $product->categories()->sync($categories_id);

            } else{

                $product_vatiation = ProductVariation::find($row['almaarf']);


                $product_vatiation->sku = isset($row['sku']) ? $row['sku'] : '' ;
                $product_vatiation->description_en =  isset($row['alosf']) ? $row['alosf'] : '' ;
                $product_vatiation->description_ar =  isset($row['alosf']) ? $row['alosf'] : '' ;

                $product_vatiation->regular_price =  isset($row['alsaar']) ? $row['alsaar'] : '' ;
                $product_vatiation->discount_price =  isset($row['saar_alaard']) ? $row['saar_alaard'] : '' ;

                $product_vatiation->min_quantity =  isset($row['akl_kmyh']) ? $row['akl_kmyh'] : '' ;
                $product_vatiation->max_quantity =  isset($row['akthr_kmy']) ? $row['akthr_kmy'] : '' ;
                $product_vatiation->stock_quantity =  isset($row['kmy_almkhzon']) ? $row['kmy_almkhzon'] : '' ;

                $product_vatiation->save();


                $attribute_value =  explode(',' ,  isset($row['alsmat']) ? $row['alsmat'] : '');
                $attribute_value_id = AttributeValue::whereIn('name_ar',array_map('trim', $attribute_value))->pluck('id');
                $product_vatiation->attribute_values()->sync($attribute_value_id);


            }




            }




    }


}
