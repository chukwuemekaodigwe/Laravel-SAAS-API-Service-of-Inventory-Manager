<?php

namespace App\Http\Controllers\Auth;
use App\Models\Branch;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Company;
use PhpParser\Node\Stmt\TryCatch;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function signup(Request $request)
    {

        $res = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        //    try{
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role_id' => 1
        ]);

        event(new Registered($user));
        //$aa = Auth::login($user);
        $token = $user->createToken('auth_token')->plainTextToken;

        //return response(['a'=>$aa, 'token'=>$token]);
        return response()->json(['message' => 'successful', 'user'=>$user, 'token'=>$token]);
    }


}