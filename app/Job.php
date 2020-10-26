<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';
    protected $fillable = ['user_id','job','detail'];

    public function job()
    {
        return $this->belongsTo(AjaxCrud::class,'user_id');
    }
}
