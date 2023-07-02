<?php

namespace App\Imports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrderImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return new Order([
            'customer_id' => $row["customer_id"],
            'date_placed' => date('Y-m-d', strtotime('1899-12-31 +' . $row["date_placed"] . ' days')),
            'date_shipped' => date('Y-m-d', strtotime('1899-12-31 +' . $row["date_shipped"] . ' days')),
            'shipping' => $row["shipping"],
            'status' => $row["status"],
        ]);
    }
}
