<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'order_id';
    protected $fillable = [
        'user_id',
        'customer_number',
        'invoice_number',
        'order_date_time',
        'notes',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_number', 'customer_number');
    }

    public function photoEvidences()
    {
        return $this->hasMany(PhotoEvidence::class, 'order_id', 'order_id');
    }
}
