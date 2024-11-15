<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    protected $fillable = [
        "link",
        "content",
        "remarks",
        "views",
        "comment",
        "like",
        "link_clicked",
        "share",
        "save"
    ];
}
