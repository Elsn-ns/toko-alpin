<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_code',
        'name',
        'category_id',
        'price',
        'price_pack',
        'units_per_pack',
        'stock',
        'description',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function incomingProducts()
    {
        return $this->hasMany(IncomingProduct::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function getStockDisplayAttribute()
    {
        if (!$this->units_per_pack || $this->units_per_pack <= 1) {
            return $this->stock . ' Pcs';
        }

        $packs = floor($this->stock / $this->units_per_pack);
        $remainder = $this->stock % $this->units_per_pack;

        if ($packs > 0 && $remainder > 0) {
            return "{$packs} Pack + {$remainder} Pcs";
        } elseif ($packs > 0) {
            return "{$packs} Pack";
        } else {
            return "{$remainder} Pcs";
        }
    }
}
