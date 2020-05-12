<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = "doctors";
    protected $fillable=['name','title','created_at','medical_id','updated_at','hospital_id'];
    protected $hidden =['created_at','updated_at','pivot'];
    public $timestamps =true;


  public function hospital()  {
      return $this->belongsTo('App\Models\Hospital','hospital_id','id');
  }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * many to manny relation
     */
  public function services() {
      return $this->belongsToMany('App\Models\Service','doctor_service','doctor_id','service_id','id','id');
  }


}

