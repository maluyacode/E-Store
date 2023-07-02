@extends('layouts.master')
@section('content')
    <div class="col-xs-6">
        <form method="post" enctype="multipart/form-data" action="{{ route('item-import') }}">
            {{ csrf_field() }}
            <input type="file" id="uploadName" name="item_upload" required>
            <button type="submit" class="btn btn-info btn-primary ">Import Excel File</button>
        </form>
        {{-- {{ link_to_route('item.export', 'Export to Excel')}} --}}
    </div>
    <div class="container">
        {!! $dataTable->table() !!}
    </div>
    {!! $dataTable->scripts() !!}
@endsection
