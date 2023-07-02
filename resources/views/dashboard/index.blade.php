@extends('layouts.master')
@section('content')
    <div class="container">
        {{-- {{dd($customerChart)}} --}}
        <div class="row">

            <div class="col-sm-6 col-md-6">
                <h2>Demographics</h2>

                @if (empty($customerChart))
                    <div></div>
                @else
                    <div>{!! $customerChart->container() !!}</div>
                    {!! $customerChart->script() !!}
                @endif
            </div>

            {{-- <div class="col-sm-6 col-md-6">
                <h2>TownDemographics</h2>

                @if (empty($townChart))
                    <div></div>
                @else
                    <div>{!! $townChart->container() !!}</div>
                    {!! $townChart->script() !!}
                @endif
            </div> --}}

        </div>
        {{-- <div class="row">
            <div class="col-sm-6 col-md-6">
                <h2>Sales Chart</h2>

                @if (empty($salesChart))
                    <div></div>
                @else
                    <div>{!! $salesChart->container() !!}</div>
                    {!! $salesChart->script() !!}
                @endif
            </div>

            <div class="col-sm-6 col-md-6">
                <h2>Product Chart</h2>

                @if (empty($itemChart))
                    <div></div>
                @else
                    <div>{!! $itemChart->container() !!}</div>
                    {!! $itemChart->script() !!}
                @endif
            </div>
        </div> --}}
    </div>
@endsection
