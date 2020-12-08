<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Records extends Model
{
    protected $table = 'records';
    protected $fillable = ['name', 'sales', 'iccid', 'pos', 'cm', 'port_in', 'referer', 'referer_number', 'plan'];
}
