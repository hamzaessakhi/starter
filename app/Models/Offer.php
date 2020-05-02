<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    // if the name of the table different of the name of the model
        protected $table = "offers";

        protected $fillable=['name','price','details','created_at','updated_at'];
        protected $hidden=['created_at','updated_at'];
        public $timestamps =false;

}
