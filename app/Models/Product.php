<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'category',
        'price',
        'image',
        'description',
        'stock_s',
        'stock_m',
        'stock_l',
        'stock_xl',
        'stock_xxl',
        'total_stock',
    ];

    /**
     * Recalculate total stock from size columns
     */
    public function calculateTotalStock()
    {
        $this->total_stock = $this->stock_s + $this->stock_m + $this->stock_l + $this->stock_xl + $this->stock_xxl;
        $this->save();
    }
}
