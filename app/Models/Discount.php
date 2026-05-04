<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use SoftDeletes;
    protected $table = 'discounts';
    protected $fillable = [
        'name',
        'percentage',
        'start_date',
        'end_date',
        'active'
    ];

    public function sales():HasMany
    {
        return $this->hasMany(Sale::class, 'discount_id', 'id');
    }
}
