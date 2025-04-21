<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;


class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        // 'email',
        'phone',
        // 'address',
        // 'city',
        // 'state',
        'loyalty_points',
        // 'zip_code',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
