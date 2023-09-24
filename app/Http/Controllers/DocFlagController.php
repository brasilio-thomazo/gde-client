<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocFlagRequest;
use App\Http\Requests\UpdateDocFlagRequest;
use App\Models\DocFlag;

class DocFlagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocFlagRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DocFlag $docFlag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocFlagRequest $request, DocFlag $docFlag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocFlag $docFlag)
    {
        //
    }
}
