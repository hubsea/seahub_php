<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyMainRequest;
use App\Models\CompanyMain;
use App\Models\EnterPriseMain;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     *  author:HAHAXIXI
     *  created_at: 2018-6-18
     *  updated_at: 2018-6-
     * @param CompanyMain $company
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *  desc   : show create page
     */
    public function create(CompanyMain $company)
    {
        return view('company.create_and_edit', compact('company'));
    }

    public function store(CompanyMainRequest $request, CompanyMain $companyMain, EnterPriseMain $enterPriseMain)
    {
        $companyMain->fill($request->all());
        $companyMain->enterprise_id = -1;
        $companyMain->save();
        $enterPriseMain->fill($request->all());
        $enterPriseMain->save();
    }
}
