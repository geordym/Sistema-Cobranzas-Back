<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renew extends Model
{
    use HasFactory;

    protected $table = "suscriptions_renews";

    protected $fillable = [
        'bill_id',
        'suscription_id',
        'duration'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function suscription()
    {
        return $this->belongsTo(Suscription::class);
    }


}
