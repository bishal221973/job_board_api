<?php

namespace App\Http\Controllers;

use App\Http\Requests\MunicipalityRequest;
use App\Models\Municipality;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    public function index(Request $request){
        $municipalities=Municipality::with('district.province.country')->latest()->paginate($request->per_page ?? 10);

        return response()->json([
            'success'=>true,
            'municipalities'=>$municipalities
        ]);
    }
    public function store(MunicipalityRequest $request){
        Municipality::create($request->validated());

        return response()->json([
            'success'=>true,
            'message'=> 'New municipality have been saved'
        ]);
    }

    public function edit($id){
        $municipality=Municipality::with('district.province.country')->find($id);

        return response()->json([
            'success'=>true,
            'data'=> $municipality
        ]);
    }

    public function update(MunicipalityRequest $request, $id){
       $municipality= Municipality::find($id);
       $data=$request->validated();
        if(!$municipality){
            return response()->json([
                'success'=>false,
                'message'=>'municipality not found'
            ],402);
        }
        $municipality->update($data);
        return response()->json([
            'success'=>true,
            'message'=>'selected municipality have been updated'
        ]);
    }

    public function destroy($id){
        $municipality=Municipality::find($id);
        if(!$municipality){
            return response()->json([
                'success'=>false,
                'message'=>'municipality not found'
            ],402);
        }
        $municipality->delete();
        return response()->json([
            'success'=>true,
            'message'=>'Selected municipality have been removed'
        ]);
    }
}
