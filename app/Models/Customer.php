<?php

namespace App\Models;

use Faker\Provider\Lorem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Customer extends Model implements HasMedia, Searchable
{
    use HasFactory, InteractsWithMedia;
    protected $table = "customer";
    protected $primaryKey = "customer_id";
    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
    public function getSearchResult(): SearchResult
    {
        $url = route('customer.show', $this->customer_id);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->lname . " " . $this->fname,
            $url
        );
    }
}
