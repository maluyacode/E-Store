<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use App\Models\Stock;
use Illuminate\Support\Facades\Session;
use App\Cart;
use Illuminate\Support\Facades\Auth;
use Facade\FlareClient\View;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\DataTables\ItemsDataTable;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\ItemExcelRule;
use App\Imports\ItemImport;
use Illuminate\Support\Facades\Redirect;
use Response;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ItemsDataTable $dataTable)
    {
        return $dataTable->render('items.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        dd($request);
        $item = new Item();
        $item->title = $request->title;
        $item->description = trim($request->description);
        $item->sell_price = $request->sell;
        $item->cost_price = $request->cost;
        // $item->image_path = $request->cost;
        $item->save();

        if ($request->document !== null) {
            foreach ($request->input("document", []) as $file) {
                $item->addMedia(storage_path("item/images/" . $file))->toMediaCollection("images");
            }
        }
        return Redirect::to("admin/items")->with(
            "success",
            "Item added successfully!"
        );
    }

    public function storeMedia(Request $request)
    {
        // dd("storeMedia");
        $path = storage_path("item/images");
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $file = $request->file("file");
        $name = uniqid() . "_" . trim($file->getClientOriginalName());
        // $file->move($path, $name);

        return response()->json([
            "name" => $name,
            "original_name" => $file->getClientOriginalName(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        // dd($request);
        return response()->json(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::destroy($id);
        return back();
    }

    public function getItems()
    {
        $items = Item::with('stock')->whereHas('stock')->get();
        // dd($items);
        // $items = Item::all();
        return view('shop.index', compact('items'));
    }

    public function addToCart(Request $request, $id)
    {
        $item = Item::find($id);
        // $oldCart = Session::has('cart') ? $request->session()->get('cart'): null;
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($item, $item->item_id);
        // $request->session()->put('cart', $cart);
        Session::put('cart', $cart);
        // $request->session()->save();
        Session::save();
        return redirect()->route('getItems');
        // dd(Session::all());
    }
    public function getCart()
    {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart', ['items' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    public function removeItem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
            Session::save();
        } else {
            Session::forget('cart');
        }
        return redirect()->route('shoppingCart');
    }

    public function getReduceByOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
            Session::save();
        } else {
            Session::forget('cart');
        }
        return redirect()->route('shoppingCart');
    }

    public function postCheckout(Request $request)
    {
        if (!Session::has('cart')) {
            return redirect()->route('shoppingCart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        // dd($cart);
        try {
            DB::beginTransaction();
            $order = new Order();
            // dd(Auth::id());
            $customer =  Customer::where('user_id', Auth::id())->first();
            // dd($customer);
            // $customer->orders()->save($order);
            $order->customer_id = $customer->customer_id;
            $order->date_placed = now();
            $order->date_shipped = now();
            // $order->shipvia = 1;
            $order->shipping = 10.00;
            $order->status = 'Processing';
            $order->save();
            // dd($order->orderinfo_id);
            foreach ($cart->items as $items) {
                $id = $items['item']['item_id'];
                // dd($id);
                DB::table('orderline')->insert(
                    [
                        'item_id' => $id,
                        'orderinfo_id' => $order->orderinfo_id,
                        'quantity' => $items['qty']
                    ]
                );
                // $order->items()->attach($id,['quantity'=>$items['qty']]);
                $stock = Stock::find($id);
                $stock->quantity = $stock->quantity - $items['qty'];
                $stock->save();
            }
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            dd($order);
            return redirect()->route('shoppingCart')->with('error', $e->getMessage());
        }
        DB::commit();
        Session::forget('cart');
        return redirect()->route('shoppingCart')->with('success', 'Successfully Purchased Your Products!!!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'item_upload' => [
                'required',
                new ItemExcelRule($request->file('item_upload')),
            ],
        ]);
        Excel::import(
            new ItemImport(),
            request()
                ->file('item_upload')
                ->store('temp')
        );

        // Excel::import(
        //     new ItemCustomerSheetImport(),
        //     request()
        //         ->file('item_upload')
        //         ->storeAs(
        //             'files',
        //             request()
        //                 ->file('item_upload')
        //                 ->getClientOriginalName()
        //         )
        // );
        // Excel::import(new FirstSheetImport, request()->file('item_upload')->store('temp'));
        return redirect()
            ->back()
            ->with('success', 'Excel file Imported Successfully');
    }
}
