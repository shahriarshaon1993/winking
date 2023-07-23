<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabric extends Model
{
    protected $fillable = [
        "cost_sheet_id",	"fabric",	"fabric_item_code",	"fabric_item_description",	"fabric_price",	"fabric_consumption","fabric_consump_unit",	"fabric_wastage",	"fabric_total_price",	"is_active"
    ];
}
