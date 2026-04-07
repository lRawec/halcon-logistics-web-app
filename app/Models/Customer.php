<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $primaryKey = 'customer_number';
    public $incrementing = false;

    protected $fillable = ['customer_number', 'name', 'fiscal_data', 'delivery_address'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_number', 'customer_number');
    }
}
