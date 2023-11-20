<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;


    protected $fillable = [
        'client_id',
        'date',
        'total',
        'expiration_date',
        'code'
    ];

    public function items()
    {
        return $this->hasMany(ItemBill::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);

    }


}
