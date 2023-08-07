<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $roles = Auth::user()->company->roles()->get();
        return response(['result' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'data.title' => ['required']
        ]);


        $req = $request->data;
        
        $new_role = Auth::user()->company->roles()->create([
            'title' => $req['title'],
            'permissions' => json_encode($req['selected']),
            'created_by' => Auth::user()->id
        ]);

        //return response($req, 500);
        return response(['result' => $new_role]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'data.title' => ['required']
        ]);
        $req = $request->data;
        $role = Role::find($req['id']);
        $new_role = $role->update([
            'title' => $req['title'],
            'permissions' => json_encode($req['selected']),
            'created_by' => Auth::user()->id
        ]);

        //return response($req, 500);
        return response(['result' => $new_role]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response(['message' => 'Role successfully deleted']);
    }
}
