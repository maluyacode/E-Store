<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
use App\Models\Item;

class Order extends Model
{
    use HasFactory;
    protected $table = "orderinfo";
    protected $primaryKey = "orderinfo_id";

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function items(){
        return $this->belongsToMany(Item::class, 'orderline', 'orderinfo_id', 'item_id')->withPivot('quantity');
    }
}
