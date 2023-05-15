@extends('layouts.master')
@section('title')
    Laravel Shopping Cart
@endsection
@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">
            {!! Session::get('success') !!}
        </div>
    @endif
    @if (Session::has('cart'))
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <ul class="list-group">
                    @foreach ($items as $item)
                        <li class="list-group-item">
                            <span class="badge">{{ $item['qty'] }}</span>
                            <strong>{{ $item['item']['description'] }}</strong>
                            <span class="label label-success">{{ $item['price'] }}</span>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary btn-xs dropdown-toogle"
                                    data-toggle="dropdown">Action <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('item.reduceByOne', ['id' => $item['item']['item_id']]) }}">Reduce
                                            By
                                            1</a></li>
                                    <li><a href="{{ route('item.remove', ['id' => $item['item']]) }}">Reduce All</a></li>
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <strong>Total: {{ $totalPrice }}</strong>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <a href="{{ route('checkout') }}" type="button" class="btn btn-success">Checkout</a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
                <h2>No Items in Cart!</h2>
            </div>
        </div>
    @endif
@endsection
