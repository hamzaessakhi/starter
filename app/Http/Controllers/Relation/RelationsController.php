<?php

namespace App\Http\Controllers\Relation;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Patient;
use App\Models\Phone;
use App\Models\Service;
use App\User;
use Illuminate\Http\Request;
use PhpParser\Comment\Doc;

class RelationsController extends Controller
{
    public function hasOneRelation() {

          $user =\App\User::with(['phone'=>function($q){
            $q->select('code','phone','user_id');
        }])->find(2);

            return $user->phone;  //funtion phone is existing in the user model
       // return response() -> json($user) ;
    }
    public function hasOneRelationReverse() {
   // $phone =Phone::with('user')->find(1);
        $phone =Phone::with(['user'=>function($q){
            $q->select('id','name');
        }])->find(1);
    //make some attribute visible /* Notice if you want  to make it hidden use function makeHidden*/

        $phone->makeVisible(['user_id']);
        // return   $phone->user; //return the user of this phone  funtion user is existing in the phone model

        //get all data + phone +user
        //return $phone;
    return $phone;
    }

    public function getUserHasPhone() {

         return User::whereHas('phone')->get();
    }

    public function getUserNotHasPhone() {

        return User::whereDoesntHave('phone')->get();

    }
    public  function getUserWhereHasPhoneWithCondition(){
        return User::whereHas('phone',function ($q){
            $q->where('code','06');
        })->get();

    }
    /*
     * end one to one relationship
     */

    /*
     * one to many relationship
     */

    public function gethospitalDoctors() {

        //$hospital= Hospital::find(1); //metjod 2  Hopdital::wher('id',1) ; //  Hopdital::first()
       // return $hospital -> doctors;

      //  $hospital =Hospital::with('doctors')->find(1);

        //   return  $hospital->name;
//        $doctors =$hospital->doctors;
//        foreach ($doctors as $doctor) {
//                $doctor->name .'<br>';
//        }

        $doctor = Doctor::find(3);
        return $doctor -> hospital->name;

    }

    public function hospitals() {

        $hospitals= Hospital::select('id','name','address')->get();

        return view('doctors.hospitals',compact('hospitals'));

    }

    public function doctors($hospital_id) {
       $hospital= Hospital::find($hospital_id);
        $doctors = $hospital->doctors;

        return view('doctors.doctors',compact('doctors'));

    }
    // get all hpspital which must has doctors
    public function hospitalsHasDoctor () {
         $hospitals = Hospital::whereHas('doctors')->get();
        return $hospitals;
    }


    public  function  hospitalHasonlyMaleDoctors() {
        return  $hospitals = Hospital::with('doctors')->whereHas('doctors',function($q){
          $q->where('gender',1);
        })->get();



    }

    public function hospitalhasNotdoctors(){
        return  Hospital::whereDoesntHave('doctors')->get();

    }
    public function deleteHospital($hospital_id) {
        $hospital = Hospital::find($hospital_id);

        if(!$hospital) {
            return abort('404');
        }
        //delete doctors in this hospital
        $hospital->doctors()->delete();

        //after delete hospital its self
        $hospital->delete();

     //   return redirect() -> route('hospital.all');


    }


    /*
     * end one to many
     */

    /**
     * start many to many
     */

    public  function getDoctorServices() {

        $doctor=Doctor::with('services')->find(2);
         return $doctor->services;

    }
    /*
     * end many to many
     */


    public  function getServicesdoctors() {

        return $doctors = Service::with(['doctors'=>function($q){
            $q->select('doctors.id','name','title');
        }])->find(1);

    }

    public  function getDoctorsServiceByID($doctorId) {
        $doctor=Doctor::find($doctorId);
        $services =$doctor ->services; //doctor services
        $doctors =Doctor::select('id','name')->get();
        $allservices = Service::select('id','name')->get(); //all database services

        return view('doctors.services',compact('services','doctors','allservices'));

    }

    public function saveServicesToDoctors(Request $request) {

       $doctor = Doctor::find($request->doctor_id);
       if(!$doctor)
           return abort('404');

       ///$doctor ->services()->attach($request -> servicesIds); //many to many insert to database
        //$doctor ->services()->sync($request -> servicesIds);
        $doctor ->services()->syncWithoutDetaching($request -> servicesIds);

        return 'success';


    }

    public function getPatientDoctors() {
        $patient =  Patient::find(1);
        return $patient->doctor;
    }

    public function getCountryDoctors() {
          $country = Country::find(1);
           return $country->doctors;
    }

}
