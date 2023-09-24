<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSearchRequest;
use App\Http\Requests\UpdateSearchRequest;
use App\Models\Search;
use App\Models\User;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * @var  User
         */
        $user = auth()->user();
        $searches = $user->searches();

        $builder = Search::orderby('name');
        if (count($searches)) {
            $builder->whereIn('id', $searches);
        }
        return response($builder->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSearchRequest $request)
    {
        $search = new Search($request->all());
        $search->save();
        return response($search, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Search $search)
    {
        return response($search, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSearchRequest $request, Search $search)
    {
        $search->update($request->all());
        return response($search, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Search $search)
    {
        $search->delete();
        return response([], 204);
    }
}
