<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\vacancyRequest;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Auth;

class VacancyController extends Controller
{
    public function index(Request $request)
    {
        $vacancies = Vacancy::with(['company.municipality.district.province.country'])->where('user_id', Auth::user()->id)->latest()->get();

        return response()->json([
            'success' => true,
            'vacancies' => $vacancies
        ]);
    }
    public function store(VacancyRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['company_id'] = Auth::user()->company->id;
        Vacancy::create($data);

        return response()->json([
            'success' => true,
            'message' => 'New vacancy published'
        ]);
    }

    public function edit($id)
    {
        $vacancy = Vacancy::with(['company.municipality.district.province.country'])->find($id);

        if (!$vacancy) {
            return response()->json([
                'success' => false,
                'message' => 'vacancy not found'
            ]);
        }
        return response()->json([
            'success' => true,
            'vacancy' => $vacancy
        ]);
    }

    public function update(VacancyRequest $request, $id)
    {
        $vacancy = Vacancy::with(['company.municipality.district.province.country'])->find($id);

        if (!$vacancy) {
            return response()->json([
                'success' => false,
                'message' => 'vacancy not found'
            ]);
        }
        $vacancy->update($request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Selected vacancy successfully updated'
        ]);

    }

    public function destroy($id){
        $vacancy = Vacancy::find($id);

        if (!$vacancy) {
            return response()->json([
                'success' => false,
                'message' => 'vacancy not found'
            ]);
        }
        $vacancy->delete();
        return response()->json([
            'success' => true,
            'message' => 'Selected vacancy removed successfully'
        ]);

    }
}
