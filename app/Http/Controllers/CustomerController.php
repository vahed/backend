<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();

        return response()->json(['customers' => $customers]);
    }

    /**
     * Store a newly created customer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$customer = new Customer;

        $customer->first_name = $request->first_name;
        $customer->family_name = $request->family_name;

        $customer->save();*/
        $customer = Customer::firstOrCreate([
            'first_name' => $request->first_name,
            'family_name' => $request->family_name,
            ]);

        return response()->json(['message' => 'Customer Added', 'product' => $customer]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        return response()->json($customer);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $firstname
     * @return \Illuminate\Http\Response
     */
    public function getFirst_name(Request $request, $first_name)
    {
        $name = Customer::where('first_name','=',$request->first_name)->get();

        return response()->json($name);
    }

    /**
     * Update customer record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        $customer->first_name = $request->get('first_name');
        $customer->family_name = $request->get('family_name');

        $customer->save();

        return response()->json('The record is updated');
    }

    /**
     * Remove the specified customer record from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        $customer->delete();

        return response()->json('Customer successfully deleted!');
    }
}
