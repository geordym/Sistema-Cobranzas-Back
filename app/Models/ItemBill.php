<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'cost',
        'description',
        'total'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
