<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use App\Models\User;


class CustomerController extends Controller
{
    public function getCompanyCustomers()
    {
        $customers = Auth::user()->company->customers()->get();
        return response()->json(['customers' => $customers], 200);
    }

    public function deleteCustomer(Request $request, Customer $customer)
    {
        $customer->delete();
        return response()->json(['message' => 'deleted successfully'], 200);
    }


    public function saveUpdate(Request $request)
    {
        $customer = $request->customer;

        $cust = Customer::find($customer['id']);
        $upd = $cust->update([
            'name' => $customer['name'],
            'phone' => $customer['phone'],
            'address' => $customer['address']
        ]);

        if ($upd) {
            return response(['message' => 'successful', 'customer' => $cust->refresh()], 200);
        } else {
            return response(['message' => 'Unsuccessful'], 500);
        }
    }

    public function getEmployees()
    {
        $users = Auth::user()->company->users()->get();
        return response(['employees' => $users]);
    }

    public function updateEmployeeInfo(Request $request)
    {

        $employ = $request->employee;
        $save = User::find($employ['id']);
        $upd = $save->update([
            'name' => $save['name'],
            'phone' => $save['phone'],
            'email' => $save['email'],
            'branch_id' => $save['branch'],
            'password' => $save['password']
        ]);

        $save->refresh();

        return response(['message' => 'successful', 'employee' => $save]);
    }

    public function deleteEmployee(Request $request)
    {
        $user = User::find($request->employee);
        $user->delete();

        return response()->noContent();
    }

}
