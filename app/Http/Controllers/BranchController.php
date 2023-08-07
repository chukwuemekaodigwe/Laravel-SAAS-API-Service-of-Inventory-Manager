<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Auth::user()->company->branches()->get();
        return response(['branches'=>$branches]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

public function store(Request $request)
    {
        $b = $request->branch;
        $branch = Auth::user()->company->branches()->create([
            'title' => $b['title'],
            'address' => $b['address'],
            'city' => $b['city'],
            'admin' => $b['admin']
        ]);

        return response(['result'=>$branch]);
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $b =  $request->branch;
        $branch = Branch::find($b['id']);
        $branch = $branch->update([
            'title' => $b['title'],
            'address' => $b['address'],
            'city' => $b['city'],
            'admin' => $b['admin']
        ]);

        
        return response(['result'=>$branch]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        //return response($branch, 500);
       $d = $branch->delete();

        return response(['message'=>'Branch successfully deleted']);
    }
}
