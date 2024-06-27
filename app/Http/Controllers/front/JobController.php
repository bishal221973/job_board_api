<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function filter(Request $request){
        $jobs=Job::with(['company.municipality.district.province.country'])
        ->when($request->filled('country_id'), function ($query) {
            $query->whereHas('company',function($comapny){
                $comapny->whereHas('municipality', function ($municipality) {
                    $municipality->whereHas('district', function ($district) {
                        $district->whereHas('province', function ($province) {
                            $province->whereHas('country', function ($country) {
                                $country->where('id', request('country_id'));
                            });
                        });
                    });
                });
            });
        })
        ->when($request->filled('province_id'), function ($query) {
            $query->whereHas('company',function($comapny){
                $comapny->whereHas('municipality', function ($municipality) {
                    $municipality->whereHas('district', function ($district) {
                        $district->whereHas('province', function ($province) {
                            $province->where('id', request('province_id'));

                        });
                    });
                });
            });
        })
        ->when($request->filled('district_id'), function ($query) {
            $query->whereHas('company',function($comapny){
                $comapny->whereHas('municipality', function ($municipality) {
                    $municipality->whereHas('district', function ($district) {
                        $district->where('id', request('district_id'));
                    });
                });
            });
        })
        ->when($request->filled('municipality_id'), function ($query) {
            $query->whereHas('company',function($comapny){
                $comapny->whereHas('municipality', function ($municipality) {
                    $municipality->where('id', request('municipality_id'));
                });
            });
        })
        ->when($request->filled('company_id'), function ($query) {
            $query->whereHas('company',function($comapny){
                $comapny->where('id', request('company_id'));
            });
        })
        ->when($request->filled('tole'), function ($query) {
            $query->where('tole', request('tole'));
        })
        ->when($request->filled('job_title'), function ($query) {
            $query->where('job_title', request('job_title'));
        })
        ->paginate($request->per_page ?? 10);

        return response()->json([
            'success'=>true,
            'jobs'=>$jobs
        ]);
    }

    public function detail($id){
        $job = Job::with(['company.municipality.district.province.country'])->find($id);

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found'
            ]);
        }

        return response()->json([
            'success'=> true,
            'jobs'=>$job
        ]);
    }
}
