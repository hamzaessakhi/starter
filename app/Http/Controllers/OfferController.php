<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Traits\OfferTrait;
use http\Env\Response;
use Illuminate\Http\Request;
use LaravelLocalization;

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

    public function all(){
       $offers = Offer::select('id',
            'price',
            'photo',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'details_'.LaravelLocalization::getCurrentLocale() . ' as details'
        )->limit(10)->get(); // return collection
        return view('ajaxoffers.all', compact('offers'));

    }

    public function delete(Request $request) {
        $offer=Offer::find($request->id);  // Offer::where('id' '$offer_id')->first();
        if (!$offer)
            return redirect()->back()->with(['error'=>__('messages.offer not exist')]);

        $offer->delete();

        return response()->json([
            'status'=>true,
            'msg'=>'م الحزق بندتح',
            'id' =>$request->id
        ]);
    }

    public  function edit(Request $request) {
        $offer= Offer::find($request->offer_id);
        if(!$offer)
           return response()->json([
               'status'=>false,
               'msg' =>' this offer not existing',
           ]);

        $offer =Offer::select('id','name_ar','name_en','details_en','details_ar','price')->find($request->offer_id);
        return view('ajaxoffers.edit',compact('offer'));

    }

    public function update(Request $request) {
        $offer=Offer::find($request->offer_id);
        if (!$offer)
            return response()->json([
                'status' => false,
                'msg' => 'هذ العرض غير موجود',
            ]);
        //update data

        $offer->update($request->all());

        return response()->json([
            'status' => true,
            'msg' => 'تم  التحديث بنجاح',
        ]);

    }


}
