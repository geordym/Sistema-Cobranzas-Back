<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'names',
        'surnames',
        'phone',
        'email',
        'address',
        'id_type',
        'identification'
    ];


    public function suscriptions()
    {
        return $this->hasMany(Suscription::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


}
