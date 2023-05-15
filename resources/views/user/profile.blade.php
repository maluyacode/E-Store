@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>{{Auth::user()->name}}</h1>
            <hr>
            <h2>My Orders</h2>
            {{$dataTable->table()}}
            {{$dataTable->scripts()}}
        </div>
    </div>
@endsection
