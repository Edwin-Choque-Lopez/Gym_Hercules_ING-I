<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;
    protected $table = 'sales';
    protected $fillable = [
        'customer_id',
        'payment_type_id',
        'discount_id',
        'user_id',
        'total',
    ];

    
    public function member():BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
    public function customer():BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function paymentType():BelongsTo
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id', 'id');
    }
    public function discount():BelongsTo
    {
        return $this->belongsTo(Discount::class, 'discount_id', 'id');
    }
    public function saleDetails():HasMany
    {
        return $this->hasMany(SaleDetail::class, 'sale_id', 'id');
    }
    
}
