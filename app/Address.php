<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $fillable = [
        'city', 'zipcode','user_id'
    ];

    public function address()
    {
        return $this->belongsTo(AjaxCrud::class,'user_id');
    }
}
