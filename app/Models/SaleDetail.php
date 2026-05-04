<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleDetail extends Model
{
    use softDeletes;
    protected $table = 'sale_details';
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];
    public function sale():BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }
    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
}
