<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;

class CompanyController extends Controller
{

    public function index()
    {
        $company = Company::with(['municipality.district.province.country'])->where('user_id', Auth::user()->id)->first();

        return response()->json([
            'success' => true,
            'company' => $company
        ]);
    }
    public function store(CompanyRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $company = Company::where('user_id', Auth::id())->first();
        if ($company) {
            return response()->json([
                'success' => false,
                'message' => 'Already have a company'
            ],402);
        }
        Company::create($data);

        return response()->json([
            'success' => true,
            'message' => 'New company have been created'
        ]);
    }

    public function update(CompanyRequest $request, $id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json([
                'success' => false,
                'message' => 'Company not found'
            ],402);
        }
        $company->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Selected company successfully update'
        ]);
    }
}
