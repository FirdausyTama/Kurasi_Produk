<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'admin_id', 'status', 'notes'];

    public function product()
{
    return $this->belongsTo(Product::class);
}

public function admin()
{
    return $this->belongsTo(User::class, 'admin_id');
}
}
