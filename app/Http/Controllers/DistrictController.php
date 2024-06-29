<?php

namespace App\Http\Controllers;

use App\Http\Requests\DistrictRequest;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index(Request $request){
        $districts = District::with('province.country')->latest()->paginate($request->per_page ?? 10);
        return response()->json([
            'success'=>true,
            'districts'=>$districts
        ]);
    }
    public function store(DistrictRequest $request){
        District::create($request->validated());

        return response()->json([
            'success'=>true,
            'message'=>'New district have been stored'
        ]);
    }

    public function edit($id){
        $district=District::with('province.country')->find($id);

        return response()->json([
            'success'=>true,
            'district'=>$district
        ]);
    }

    public function update(DistrictRequest $request, $id){
        $district= District::find($id);
        $data=$request->validated();
         if(!$district){
             return response()->json([
                 'success'=>false,
                 'message'=>'district not found'
             ],402);
         }
         $district->update($data);
         return response()->json([
             'success'=>true,
             'message'=>'selected district have been updated'
         ]);
    }

    public function destroy($id){
        $district=District::find($id);
        if(!$district){
            return response()->json([
                'success'=>false,
                'message'=>'district not found'
            ],402);
        }
        $district->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Selected district have been removed'
        ]);
    }
}
