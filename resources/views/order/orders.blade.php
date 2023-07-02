@extends('layouts.master')

@section('content')
    <div class="row">
        @include('layouts.flash-messages')
        <div class="col">
            <div class="row">
                <div class="col-md-9">
                    <h1>All Orders</h1>
                </div>
                <div class="col-md-3" style="margin-top: 30px ">
                    <form action="{{ route('orders.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <input type="file" name="orders">
                            </div>
                            <div class="col-md-3">
                                <button type="submit">Submit</button>
                            </div>
                            @error('orders')
                            <small style="color: red">{{ $message }}</small>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            {{ $dataTable->table() }}
            {{ $dataTable->scripts() }}
        </div>
    </div>
    <script></script>
@endsection
