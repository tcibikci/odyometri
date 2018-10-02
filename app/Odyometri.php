<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Odyometri extends Model
{
    protected $table = "odyometris";

    public function  scopeID($query, $app)
    {
        return $query->where('id', '=', $app);
    }
}
