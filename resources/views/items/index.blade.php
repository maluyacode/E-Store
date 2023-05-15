@extends('layouts.master')
@section('content')
    <div class="container">
        {!! $dataTable->table() !!}
    </div>
    {!! $dataTable->scripts() !!}
@endsection
