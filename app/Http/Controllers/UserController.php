<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $users = Auth::user()->company->users()->get();
        return response(['result'=>$users]);
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

        $res = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        //    try{
        $user = Auth::user()->company->users()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'branch_id' => $request->branch
        ]);

        return response(['result'=>$user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $res = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        //    try{
        $user = User::find($request->id);

        $user->update([
            'name' => $request->name,
            
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
            'branch_id' => $request->branch
        ]);

        return response(['result'=>$user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id)->delete();
        return response(['message'=> 'Employee successfully removed']);
    }
}
