<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProvinceRequest;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{

    public function index(Request $request){
        $provinces=Province::with('country')->latest()->paginate($request->per_page ?? 10);

        return response()->json([
            'success'=>true,
            'provinces'=>$provinces
        ]);
    }
    public function store(ProvinceRequest $request){
        Province::create($request->validated());

        return response()->json([
            'success'=>true,
            'message'=> 'New province have been saved'
        ]);
    }

    public function edit($id){
        $province=Province::with('country')->find($id);

        return response()->json([
            'success'=>true,
            'data'=> $province
        ]);
    }

    public function update(ProvinceRequest $request, $id){
       $province= Province::find($id);
       $data=$request->validated();
        if(!$province){
            return response()->json([
                'success'=>true,
                'message'=>'province not found'
            ]);
        }
        $province->update($data);
        return response()->json([
            'success'=>true,
            'message'=>'selected province have been updated'
        ]);
    }

    public function destroy($id){
        $province=Province::find($id);
        if(!$province){
            return response()->json([
                'success'=>false,
                'message'=>'Province not found'
            ]);
        }
        $province->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Selected province have been removed'
        ]);
    }
}
