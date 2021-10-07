<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 04/08/19
 * Time: 10:08 ص
 */

namespace App\Traits;




trait LanguageTrait
{

   public function getName($model)
   {
       $attr = "name_".app()->getLocale();
       return $model->$attr;
   }
    public function getTitle($model)
    {
        $attr = "title_".app()->getLocale();
        return $model->$attr;
    }

    public function getDescription($model)
    {
        $attr = "description_".app()->getLocale();
        return $model->$attr;
    }

    public function getValue($model)
    {
        $attr = "value_".app()->getLocale();
        return $model->$attr;
    }
    public function getCapital($model)
    {
        $attr = "capital".app()->getLocale();
        return $model->$attr;
    }

    public function getSlug($model)
    {
        $attr = "slug_".app()->getLocale();
        return $model->$attr;
    }

    public function getText($model)
    {
        $attr = "text_".app()->getLocale();
        return $model->$attr;
    }

    public function getSymbol($model)
    {
        $attr = "symbol_".app()->getLocale();
        return $model->$attr;
    }

    public function getShippingCompanyPriceText($model)
    {
        $attr = "shipping_company_price_text_".app()->getLocale();
        return $model->$attr;
    }

    public function getNote($model)
    {
        $attr = "note_".app()->getLocale();
        return $model->$attr;
    }
    public function getImage($model)
    {
        $attr = "image_".app()->getLocale();
        return $model->$attr;
    }

    public function getImageWebsite($model)
    {
        $attr = "image_website_".app()->getLocale();
        return $model->$attr;
    }
    public function getNickName($model) {
        $attr = "nickname_".app()->getLocale();
        return $model->$attr;
    }

    public function getAddress($model) {
        $attr = "address_".app()->getLocale();
        return $model->$attr;
    }

}