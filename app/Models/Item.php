<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Models\Order;
use App\Models\Stock;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Item extends Model implements HasMedia, Searchable
{
    use HasFactory;
    use InteractsWithMedia;
    protected $table = "item";
    protected $primaryKey = "item_id";

    public $fillable = [
        "description",
        "sell_price",
        "cost_price",
        "img_path",
        "title"
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'orderline', 'orderinfo_id', 'item_id');
    }
    public function stock()
    {
        return $this->hasOne(Stock::class, 'item_id');
    }
    public function registerMediaConversions(Media $media = null) : void
    {
        $this->addMediaConversion('thumb')
              ->width(200)
              ->height(200)
              ->sharpen(10);
    }

    public function getSearchResult(): SearchResult
    {
       $url = route('item.show', $this->item_id);

        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->title,
           $url
        );
    }
}
