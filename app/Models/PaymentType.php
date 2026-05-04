<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentType extends Model
{
    use SoftDeletes;
    protected $table = 'payment_types';
    protected $fillable = [
        'name',
    ];

    public function sales():HasMany
    {
        return $this->hasMany(Sale::class, 'payment_type_id', 'id');
    }
}
