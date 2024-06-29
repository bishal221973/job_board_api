<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\ApprovalRequest;
use App\Models\Application;
use App\Jobs\SendRegisteredMail;
class ApplicationController extends Controller
{
    public function store(ApplicationRequest $request,$jobId){
        $data=$request->validated();
        $data["job_id"]=$jobId;
        $data["user_id"]=Auth::id();
        $data["vacancy_id"]=$jobId;

        if($request->file("resume")){
            $data["resume"]=$request->file("resume")->store("resume");
        }
        $application=Application::create($data);
        dispatch(new SendRegisteredMail($application));
        return response()->json([
            'success'=>true,
            'message'=> 'Successfully submit your application'
        ]);
    }

    public function list(Request $request){
        $applications = Application::whereHas('vacancy.user', function ($query) {
            $query->where('id', auth()->id());
        })->with('vacancy','user')->where('status',true)->paginate($request->per_page ?? 20);
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
        dispatch(new SendRegisteredMail($application))->delay(now()->addMinutes(1));
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
