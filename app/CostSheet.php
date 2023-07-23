<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostSheet extends Model
{
    protected $fillable =[
        "user_id","customer_id","style_no",	"season","brand","size_scale","item_description","order_quantity","target_price","fabric_total_cost","trim_total_cost",	"making_price","washing_description","washing_price","other_price","dry_process_price","dry_process_description","cmptw_wastage","cmptw_total_price","fob_wastage","fob_total_price","tf_wastage","tf_cost","offered_fob","cil_wastage","cil_price", "commercial_cost", "cc_amount", "total_cost_wastage","total_cost","wastage_per_pc","cost_per_pc","is_active"
    ];

    public function fabrics(){
        return $this->hasMany('App\Fabric');
    }

    public function costSheetDetails(){
        return $this->hasMany('App\CostSheetDetails');
    }

    public function customer(){
        return $this->belongsTo('App\Customer','customer_id');
    }
}
