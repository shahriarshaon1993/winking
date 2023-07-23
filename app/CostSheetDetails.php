<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostSheetDetails extends Model
{
    protected $fillable =[
        "cost_sheet_id","trimming",	"trim_item_code","trim_item_description","trim_price","trim_consumption","trim_consump_unit","trim_wastage","trim_total_price",	"is_active"
    ];
}
