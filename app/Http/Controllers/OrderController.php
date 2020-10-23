<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();

        return response()->json(['orders' => $orders]);
    }

    /**
     * Store a newly created order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Get all the records from join tables.
     *
     * @param  get all orders
     * @return \Illuminate\Http\Response
     */
    public function getAllOrders()
    {
        $orders = DB::select('
            select order_number,quantity,order_date,
                   concat(first_name,\' \',family_name) as customer,
                   SUM(cost * quantity) as total
            FROM
            (
                SELECT
                  order_number,customer_number,product_number,oi.quantity,
                  oi.order_date,p.cost,c.first_name,c.family_name
                FROM orders
                    join ordered_items as oi on(orders.order_number=oi.order_id)
                    join products as p on (orders.product_number = p.id)
                    join customers as c on (orders.customer_number = c.id)
                    GROUP BY product_number
                    ORDER BY order_number ASC
                ) AS allcosts
            group by order_number
        ');

        return response(['orders' => $orders]);
    }
}
