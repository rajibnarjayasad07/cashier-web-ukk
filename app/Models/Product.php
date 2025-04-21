<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailTransaction;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'price', 'stock', 'image'];

    public function detailSales()
    {
        return $this->hasMany(DetailTransaction::class);
    }
}
