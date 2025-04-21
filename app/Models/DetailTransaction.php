<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Transaction;

class DetailTransaction extends Model
{
    use HasFactory;
    protected $fillable = ['transaction_id', 'product_id', 'amount', 'sub_total'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

}
