<?php


namespace App\Http\Controllers;
use App\Events\VideoViewer;
use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Models\Video;
use App\Traits\OfferTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LaravelLocalization;

class CrudController extends Controller{

    use OfferTrait;

    public function __construct() {
    }
    public function getOffers() {
        return Offer::select('id','name')->get();
    }
    public function create() {
        return view('offers.create');
    }
    public function store(OfferRequest $request){


      $file_name=  $this->saveImage($request->photo,'images/offers');


        //insert to database
        Offer::create([
            'photo'=> $file_name,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'details_ar' => $request->details_ar,
            'details_en' => $request->details_en,

        ]);

        return redirect()->back()->with(['success' => 'تم اضافه العرض بنجاح ']);
    }

    public function getAllOffers()
    {
        $offers = Offer::select('id',
            'price',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'details_'.LaravelLocalization::getCurrentLocale() . ' as details'
        )->get(); // return collection
        return view('offers.all', compact('offers'));
    }

    public function editOffer($offer_id){
      //  Offer::findOrFail($offer_id);
       $offer=  Offer::find($offer_id);
         if(!$offer)
             return redirect()->back() ;

        $offer =Offer::select('id','name_ar','name_en','details_en','details_ar','price')->find($offer_id);
        return view('offers.edit',compact('offer'));


    }

    public function updateOffer(OfferRequest $request,$offer_id ) {
        //validation

        //check if offer exist


        $offer=  Offer::find($offer_id);
        if(!$offer)
            return redirect()->back() ;

        //update data

        $offer->update($request->all());
        return redirect() ->back()->with(['success'=>'تم التحديث بنجاح']);

        /*$offer->update([
            'name_ar'=>$request->name_ar,
            'name_en'=>$request->name_en,
            'price'=>$request->price,
        ])*/

    }

    public function  getVideo() {
       $video= Video::first();
       event(new VideoViewer($video));
       return view('video')->with('video',$video);
    }

    public function deleteOffer($offer_id) {
        //check if offer id exists

       $offer=Offer::find($offer_id);  // Offer::where('id' '$offer_id')->first();
        if (!$offer)
            return redirect()->back()->with(['error'=>__('messages.offer not exist')]);

        $offer->delete();

        return redirect()
            ->route('offers.all')
            ->with(['success'=>__('messages.offer deleted successfully')]);




    }
}
