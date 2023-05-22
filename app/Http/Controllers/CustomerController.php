<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $order = Order::find(51);
        // dump($order->customer);

        // $orders = Order::all();
        // foreach ($orders as $order) {
        //     dump($order->orderinfo_id);
        //     dump($order->customer);
        // }

        // $customer = Customer::with('orders')->find(17);
        // dump($customer);

        // $customers = Customer::with('orders')->get();
        // foreach($customers as $customer){
        //     dump($customer->customer_id);
        //     foreach($customer->orders as $order){
        //         dump($order->date_placed);
        //     }
        // }

        // $order = Order::find(51);
        // foreach($order->items as $item){
        //     dump($item->pivot->quantity);
        // }

        $customers = Customer::with('orders')->get();
        foreach($customers as $customer){
            dump($customer->customer_id);
            foreach($customer->orders as $order){
                dump("Order",$order->date_placed);
                dump($order->items);
            }
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
