<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailTransaction;
use App\Models\User;
use App\Models\Customer;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_date', 
        'total_price', 
        'total_payment', 
        'total_return', 
        'customers_id', 
        'users_id', 
        'loyalty_points', 
        'total_point'
    ];

    /**
     * Get the detail sales associated with the transaction.
     */
    public function detailTransaction()
    {
        return $this->hasMany(DetailTransaction::class, 'transaction_id');
    }

    /**
     * Get the customer associated with the transaction.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customers_id');
    }

    /**
     * Get the staff who created the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
