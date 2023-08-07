<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Company;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StockController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Models\Role;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */


    public function store(LoginRequest $request)
    {
      $r =  $request->authenticate();
        $user = Auth::user();
        $user1 = $user;

        $request->session()->regenerate();
        $company = $user->company;

        //return response($company->admin);
        $branch = $user->branch;
        $user->company->products;
        $user->company->branches;
        $user->company->users;
        $role = $user->role;
        
        if ($role != 1 && !empty($role)) {
            $user->permission = Role::find($role)->permissions;
            //$user->role = Role::find($role)->title;
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        //return response($user, 500);
        return response()->json([
            'token' => $token,
            'result' => $user, 'user' => $user1,
        ]);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {

        auth()->user()->tokens()->delete();

        $res = Auth::guard('web')->logout();
        //return response($res);
        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        return response()->noContent();
    }
}
