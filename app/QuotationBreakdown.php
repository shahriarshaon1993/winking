<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationBreakdown extends Model
{
    protected $fillable =[

        "purchase_id","color","color_code","sub_total","color_unit_price","color_wise_quantity","size1","size2","size3","size4","size5","size6","size7","size8","size9","size10","size11","size12","size13","prepack1","prepack2","prepack3","prepack4","prepack5","prepack6","prepack7","prepack8","prepack9","prepack10","prepack11","prepack12","prepack13",	"quantity1","quantity2","quantity3","quantity4","quantity5","quantity6","quantity7","quantity8","quantity9","quantity10","quantity11","quantity12","quantity13","is_active"
    ];

}
