<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(){
        $countries = Country::latest()->get();
        return response()->json([
            'success'=>true,
            'countries'=>$countries
        ]);
    }
    public function store(CountryRequest $request){
        Country::create($request->validated());

        return response()->json([
            'success'=>true,
            'message'=>'New country have been stored'
        ]);
    }

    public function edit($id){
        $country=Country::find($id);

        return response()->json([
            'success'=>true,
            'country'=>$country
        ]);
    }

    public function update(CountryRequest $request, $id){
        $country= Country::find($id);
        $data=$request->validated();
         if(!$country){
             return response()->json([
                 'success'=>false,
                 'message'=>'country not found'
             ]);
         }
         $country->update($data);
         return response()->json([
             'success'=>true,
             'message'=>'selected country have been updated'
         ]);
    }

    public function destroy($id){
        $country=Country::find($id);
        if(!$country){
            return response()->json([
                'success'=>false,
                'message'=>'Country not found'
            ]);
        }
        $country->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Selected country have been removed'
        ]);
    }
}
