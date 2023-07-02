<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\CustomerChart;
use Illuminate\Support\Facades\DB;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     $this->bgcolor = collect([
    //         '#7158e2',
    //         '#3ae374',
    //         '#ff3838',
    //         "#FF851B",
    //         "#7FDBFF",
    //         "#B10DC9",
    //         "#FFDC00",
    //         "#001f3f",
    //         "#39CCCC",
    //         "#01FF70",
    //         "#85144b",
    //         "#F012BE",
    //         "#3D9970",
    //         "#111111",
    //         "#AAAAAA",
    //     ]);
    // }

    public function index()
    {
        // Debugbar::info($customer);
        $customer = DB::table('customer')
            ->whereNotNull('title')
            ->groupBy('title')
            ->orderBy('total')
            ->pluck(DB::raw('count(title) as total'), 'title')
            ->all();
        Debugbar::addMessage($customer);
        // $customer = asort($customer,SORT_REGULAR );
        // dd($customer);
        $customerChart = new CustomerChart();
        // dd(array_keys($customer));
        $dataset = $customerChart->labels(array_keys($customer));
        // dd($dataset);
        $dataset = $customerChart->dataset(
            'Customer Demographics',
            'horizontalBar',
            array_values($customer)
        );
        // dd($customerChart);
        $dataset = $dataset->backgroundColor([
            '#7158e2',
            '#3ae374',
            '#ff3838',
            "#FF851B",
            "#7FDBFF",
            "#B10DC9",
            "#FFDC00",
            "#001f3f",
            "#39CCCC",
            "#01FF70",
            "#85144b",
            "#F012BE",
            "#3D9970",
            "#111111",
            "#AAAAAA",
        ]);
        // dd($customerChart);
        $customerChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled' => true],
            // 'maintainAspectRatio' =>true,

            // 'title' => 'test',
            'aspectRatio' => 1,
            'scales' => [
                'yAxes' => [
                    [
                        'display' => false,
                        'ticks' => ['beginAtZero' => true],
                        'gridLines' => ['display' => false],
                    ],
                ],
                'xAxes' => [
                    [
                        'categoryPercentage' => 0.8,
                        //'barThickness' => 100,
                        'barPercentage' => 1,
                        'ticks' => ['beginAtZero' => false],
                        'gridLines' => ['display' => false],
                        'display' => true,
                    ],
                ],
            ],
        ]);
        return View::make('dashboard.index', compact('customerChart'));
    }
}
