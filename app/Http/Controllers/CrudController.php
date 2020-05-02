<?php


namespace App\Http\Controllers;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CrudController extends Controller
{

    public function __construct() {

    }

    public function getOffers() {
        return Offer::select('id','name')->get();

    }
   /* public function store(){
        Offer::create([
            'name'=>'Offer3',
            'price'=>'5000',
            'details'=>'Offer details '

        ]);

    }*/

    public function create() {
        return view('offers.create');
    }

    public function store(Request $request){

        //Validate data before insert to database



        $messages=$this->getMessages();
        $rules=$this->getRules();
        $validator = Validator::make($request->all(),$rules,$messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        //insert
        Offer::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'details'=>$request->details
        ]);

        return redirect()->back()->with(['success'=>'le champs est ajouté avec succés']);

    }
    protected function getMessages() {
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

    }

}
