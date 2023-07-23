<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        "name","code","category_id","details","tax_id","tax_method","price","is_active"
    ];

    public function category(){
        return $this->belongsTo('App\ServiceCategory');
    }
    public function tax(){
        return $this->belongsTo('App\Tax');
    }
}
