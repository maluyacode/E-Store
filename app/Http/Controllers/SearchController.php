<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Customer;
use Spatie\Searchable\Search;


class SearchController extends Controller
{
    public function search(Request $request) {
        $searchResults = (new Search())
        ->registerModel(Item::class, ['description', 'title'])
        ->registerModel(Customer::class, ['lname', 'fname', 'town'])
        ->search(trim($request->term));
        // dd($request->term);
        return view('search', compact("searchResults"));
    }
}
