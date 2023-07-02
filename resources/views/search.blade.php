@extends('layouts.master')
@section('content')
    <h1>Search</h1>

    There are {{ $searchResults->count() }} results.
    {{-- {{ dd($searchResults) }} --}}
    @foreach ($searchResults->groupByType() as $type => $modelSearchResults)
        <h2>{{ $type }}</h2>
        {{ dd($modelSearchResults) }}
    {{-- {{ dd($modelSearchResults["customer"]) }} --}}
        @foreach ($modelSearchResults as $searchResult)
            <ul>
                <a href="{{ $searchResult->url }}">{{ $searchResult->title }}</a>
            </ul>
        @endforeach
    @endforeach
@endsection
