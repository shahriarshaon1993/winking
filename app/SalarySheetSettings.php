<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalarySheetSettings extends Model
{
    protected $fillable = ['h_rent', 'medical', 't_port'];
}
