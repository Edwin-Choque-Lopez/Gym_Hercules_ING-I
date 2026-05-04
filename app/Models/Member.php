<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
    protected $table = 'members';
    protected $fillable = [
        'ci',
        'full_name',
        'phone',
        'is_active',

    ];

    public function sales():HasMany
    {
        return $this->hasMany(Sale::class, 'member_id', 'id');
    }
}
