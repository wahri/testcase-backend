<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function list(Request $request)
    {
        $company = Company::all();
        return response()->json([
            'message' => 'Company list retrieved successfully',
            'company' => $company,
        ]);
    }

    public function detail($id)
    {
        $company = Company::findOrFail($id);
        return response()->json([
            'message' => 'Company detail retrieved successfully',
            'company' => $company,
        ]);
    }
}
