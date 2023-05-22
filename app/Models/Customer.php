<?php

namespace App\Models;

use Faker\Provider\Lorem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Customer extends Model
{
    use HasFactory;
    protected $table = "customer";
    protected $primaryKey="customer_id";
    public $timestamps = false;

    public function orders(){
        return $this->hasMany(Order::class, 'customer_id');
    }
}
