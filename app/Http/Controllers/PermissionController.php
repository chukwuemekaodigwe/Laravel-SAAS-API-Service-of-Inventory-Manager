<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $num = Permission::createPermissionTable();
        return response(['message'=>$num]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getPermisssions(): Response
    {
        $p = Permission::all();
        return response(['result'=>$p]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        //
    }


}
