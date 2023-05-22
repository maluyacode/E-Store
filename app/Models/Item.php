<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Item extends Model
{
    use HasFactory;
    protected $table = "item";
    protected $primaryKey = "item_id";

    public function orders(){
        return $this->belongsToMany(Order::class, 'orderline', 'orderinfo_id', 'item_id');
    }
}
