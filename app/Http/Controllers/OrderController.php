<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\OrderDataTable;
use App\Imports\OrderImport;
use App\Rules\OrderExcelRule;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function orders(OrderDataTable $dataTable){
        return $dataTable->render('order.orders');
    }

    public function import(Request $request){
        // dd($request);
        $request->validate([
            'orders' => [
                'required',
                new OrderExcelRule($request->file('orders')),
            ],
        ]);
        Excel::import(
            new OrderImport(),
            request()->file('orders')->store('temp')
        );
        return redirect()
        ->back()
        ->with('success', 'Excel file Imported Successfully');
    }
}
