<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_model extends Model
{
    protected $table='cities';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

}
