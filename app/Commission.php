<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $table = 'commission';
    protected $fillable = ['user_id', 'items', 'commission', 'bonus'];
}
