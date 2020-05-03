<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' =>'required|max:100|unique:offers,name',
            'price' =>'required|numeric',
            'details'=>'required'
        ];
    }

    public function messages()
    {
     //   return parent::messages(); // TODO: Change the autogenerated stub
        return $messages=[
            'name.required' => __('messages.offer name required'),
            'name.unique' => __('messages.offer name must unique'),
            'price.required' => 'le prix est est obligatoire',
            'price.numeric' => 'le prix est doit etre numerique',
            'details.required' => 'les details sont  obligatoires',
        ];

    }

}
