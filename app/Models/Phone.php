<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected  $table="phone";
    protected  $fillable=['code','phone','user_id'];
    protected  $timestamp= false;

}
