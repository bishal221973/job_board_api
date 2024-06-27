<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Requests\JobRequest;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = Job::with(['company.municipality.district.province.country', 'user'])->where('user_id', Auth::user()->id)->latest()->get();

        return response()->json([
            'success' => true,
            'jobs' => $jobs
        ]);
    }
    public function store(JobRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        Job::create($data);

        return response()->json([
            'success' => true,
            'message' => 'New job published'
        ]);
    }

    public function edit($id)
    {
        $job = Job::with(['company.municipality.district.province.country'])->find($id);

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found'
            ]);
        }
        return response()->json([
            'success' => true,
            'job' => $job
        ]);
    }

    public function update(JobRequest $request, $id)
    {
        $job = Job::with(['company.municipality.district.province.country'])->find($id);

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found'
            ]);
        }
        $job->update($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Selected job successfully updated'
        ]);

    }

    public function destroy($id){
        $job = Job::find($id);

        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found'
            ]);
        }
        $job->delete();
        return response()->json([
            'success' => true,
            'message' => 'Selected job removed successfully'
        ]);

    }
}
