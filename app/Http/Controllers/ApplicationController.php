<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\ApprovalRequest;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function store(ApplicationRequest $request,$jobId){
        $data=$request->validated();
        $data["job_id"]=$jobId;
        $data["user_id"]=Auth::id();

        if($request->file("resume")){
            $data["resume"]=$request->file("resume")->store("resume");
        }
        Application::create($data);

        return response()->json([
            'success'=>true,
            'message'=> 'Successfully submit your application'
        ]);
    }

    public function list(Request $request){
        $applications = Application::whereHas('job.user', function ($query) {
            $query->where('id', auth()->id());
        })->with('job.user')->where('status',true)->paginate($request->per_page ?? 20);
        return response()->json([
            'success'=>true,
            'applications'=>$applications
        ]);
    }

    public function approval(ApprovalRequest $request,$applicationId){
        $application=Application::where('status',true)->where('isApproved',false)->find($applicationId);
        if(!$application){
            return response()->json([
                'success'=>false,
                'message'=> 'Application not found'
            ]);
        }

        $application->update([
            'isApproved'=>$request->isApproved,
            'status'=>false,
        ]);
        if($request->isApproved){
            $msg="Application approved";
        }else{
            $msg="Application rejected";
        }

        return response()->json([
            'success'=>true,
            'message'=> $msg
        ]);
    }
}
