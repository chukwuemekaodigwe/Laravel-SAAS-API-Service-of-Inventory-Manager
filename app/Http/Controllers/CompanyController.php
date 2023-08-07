<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Branch;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getCompany()
    {
        $company = Auth::user()->company;

        return response(['result' => $company]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $req = $request->data;
        $company = Company::create([
            'name' => $req['name'],
            'address' => $req['address'],
            'phone' => $req['phone'],
            'email' => $req['email'],
            'country' => $req['country'],
            'city' => $req['city'],
            'timezone' => $req['timezone'],
            'currency' => $req['currency'],
            'registry_by_user' => $req['acct_type'],
            'admin' => Auth::user()->id,

        ]);

        $branch = Branch::create([
            'title' => 'Head Office',
            'address' => $req['address'],
            'city' => $req['city'],
            'admin' => Auth::user()->id,
            'company_id' => $company->id
        ]);


        $user = User::find(Auth::user()->id);
        $upd = $user->update([
            'branch_id' => $branch->id,
            'company_id' => $company->id
        ]);

        return response(['result' => $company]);

        // if($company){
        //     Subscription::where('user', Auth::user()->id);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function getTheme(): Response
    {
        $theme = Auth::user()->company->color;
        return response(['result' => $theme]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function saveTheme(Request $request): Response
    {
        $company = Company::find(Auth::user()->company->id);
        $company->color = json_encode($request->data);
        $company->save();


        return response(['result' => Auth::user()->company]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        /**
         * Registry by user
         * Subscription Plan
         */

        $req = $request->data;
        $imagepath = $req['logo'];

        // if (!is_string($imagepath) && !empty($imagepath)) {
        //     $image_path = $imagepath->store('public/');
        // } else {
            $image_path = '';
        //}

        $upd = Auth::user()->company->update([
            'name' => $req['name'],
            'address' => $req['address'],
            'phone' => $req['phone'],
            'email' => $req['email'],
            'country' => $req['country'],
            'city' => $req['city'],
            'timezone' => $req['timezone'],
            'currency' => $req['currency'],
            'registry_by_user' => $req['acct_type'],
            'logo' => $image_path,

        ]);


        return response(['message' => 'successful']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company): RedirectResponse
    {
        //
    }
}
