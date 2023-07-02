<?php

namespace App\DataTables;

use App\Models\Order;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;

class OrderDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->collection($query)
            ->addColumn('action',  function ($row) {
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
            })
            ->addColumn('total', function($order){
                return number_format($order->items->map(function($item){
                    return $item->pivot->quantity * $item->sell_price;
                })->sum(), 2);
            })
            ->addColumn('items', function($order){
                return $order->items->map(function($item){
                    return $item->title;
                })->implode('<br>');
            })
            ->rawColumns(['action', 'items']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        $orders = Order::with(['customer', 'items'])
        ->orderBy('date_placed', 'DESC')->get();

        Debugbar::info($model);

        return $orders;
        // return $orders = DB::table('customer as c')->join('orderinfo as o', 'o.customer_id', '=', 'c.customer_id')
        //     ->join('orderline as ol', 'o.orderinfo_id', '=', 'ol.orderinfo_id')
        //     ->join('item as i', 'ol.item_id', '=', 'i.item_id')
        //     ->where('c.user_id', Auth::id())
        //     ->select('o.orderinfo_id', 'o.date_placed', DB::raw("SUM(ol.quantity * i.sell_price) as total"))
        //     ->groupBy('o.orderinfo_id', 'o.date_placed');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('order-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('orderinfo_id'),
            Column::make('date_placed'),
            Column::make('total'),
            Column::make('items'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Order_' . date('YmdHis');
    }
}
