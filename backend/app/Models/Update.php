<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    protected $fillable = [
        "visitors",
        "time",
        "date"
    ];
}
