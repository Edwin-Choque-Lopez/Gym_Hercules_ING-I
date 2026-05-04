<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'price_sell',
        'price_buy',
        'expiration_date',
        'current_stock',
        'min_stock',
        'category_id'
    ];
    public function category():BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'category_id', 'id');
    }
    public function salesDetails():HasMany
    {
        return $this->hasMany(SaleDetail::class, 'product_id', 'id');
    }
}
