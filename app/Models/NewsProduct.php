<?php

namespace App\Models;

use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;

// models
use App\Models\Product;

class NewsProduct extends Model implements Feedable
{

    public function toFeedItem()
    {
        return Product::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->description)
            ->updated($this->updated_at)
            ->link()
            ->author('admin');
    }
    public static function getFeedItems()
    {
        return static::all();
    }
    public function getLinkAttribute()
    {
        return route('news_product.show', $this);
    }
}
