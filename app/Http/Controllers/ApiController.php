<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Product;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created order new .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = new Customer;

        $product = new Product;

        $neworder = new Order;
        $neworder->customer_number = $this->getCustomerId($request);
        $neworder->product_number = $this->getProdId($request);
        $neworder->quantity = $request->quantity;
        //$neworder->cost = $request->cost;
        $neworder->total = $this->calcTotal($request);
        $neworder->order_date = now();
        //$this->calcTotal($request);
        $neworder->save();

        return response()->json(['message' => 'Product Added', 'product' => $neworder]);
    }

    /**
     * Get customer id matched with the input.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCustomerId(Request $request)
    {
        $customer_id = Customer::where('first_name', $request->first_name)
            ->orWhere('family_name', $request->family_name)
            ->first()
            ->id;

        return $customer_id;
        //return response()->json(['message' => 'Customer id found', 'customer_id' => $customer_id]);
        //return response()->json($customer_id);
    }

    /**
     * Get product id matched with the input.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProdId(Request $request)
    {
        $product_id = Product::where('description', $request->description)
            ->orWhere('cost', $request->cost)
            ->first()
            ->id;

        return $product_id;
        //return response()->json(['message' => 'Product id found', 'product_id' => $product_id]);
    }

    /**
     * Calculate total amount of products ordered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calcTotal(Request $request)
    {
        $total = $request->cost * $request->quantity;

        return $total;
        //return response()->json(['message' => 'Product id found', 'Total' => $total]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
