<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Traits\OfferTrait;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    use OfferTrait;

    public  function create() {
        //view to add this offer
        return view('ajaxOffers.create');
    }

    public function store(OfferRequest $request){

      $file_name=  $this->saveImage($request->photo,'images/offers');


        //insert
        $offer= Offer::create([
         'photo'=> $file_name,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'details_ar' => $request->details_ar,
            'details_en' => $request->details_en,

        ]);

     //   return redirect()->back()->with(['success' => 'تم اضافه العرض بنجاح ']);

        if($offer)
        return response()->json([
            'status'=>true,
            'msg'=>'تم الحفظ بنداح',
        ]);

        else
            return response()->json([
                'status'=>false,
                'msg'=>'فشل الحفظ',

            ]);

    }




}
