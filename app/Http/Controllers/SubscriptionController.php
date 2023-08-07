<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Plan;


class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $result = Plan::all();
        return response(['result'=>$result]);
    }

    /**
     * Renew or subscribe to subscription plan
     */
    public function renewPlan(Request $request): Response
    {
        $sub = Auth::user()->company->subscriptions->create([

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription): RedirectResponse
    {
        //
    }
}
