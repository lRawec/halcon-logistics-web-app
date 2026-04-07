<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoEvidence extends Model
{
    protected $table = 'photo_evidences';

    protected $fillable = [
        'order_id',
        'file_path',
        'upload_date',
        'type'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
