<?php


namespace App\Http\Controllers;
use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LaravelLocalization;

class CrudController extends Controller
{

    public function __construct() {

    }

    public function getOffers() {
        return Offer::select('id','name')->get();

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

    public function create() {
        return view('offers.create');
    }

    public function store(OfferRequest $request){

        //Validate data before insert to database
        // $messages=$this->getMessages();
        //$rules=$this->getRules();
        //$validator = Validator::make($request->all(),$rules,$messages);

        //if($validator->fails()){
          //  return redirect()->back()->withErrors($validator)->withInput($request->all());
        //}

        //insert
        Offer::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'details_ar' => $request->details_ar,
            'details_en' => $request->details_en,

        ]);

        return redirect()->back()->with(['success' => 'تم اضافه العرض بنجاح ']);

    }
   /* protected function getMessages() {
        return $messages=[
            'name.required' => __('messages.offer name required'),
            'name.unique' => __('messages.offer name must unique'),
            'price.required' => 'le prix est est obligatoire',
            'price.numeric' => 'le prix est doit etre numerique',
            'details.required' => 'les details sont  obligatoires',

        ];
    }

    protected function getRules() {
        return  $rules=[
            'name' =>'required|max:100|unique:offers,name',
            'price' =>'required|numeric',
            'details'=>'required'
        ];

    }*/

}
