<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingProduct extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'note',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
