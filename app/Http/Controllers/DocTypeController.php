<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocTypeRequest;
use App\Http\Requests\UpdateDocTypeRequest;
use App\Models\DocType;
use App\Models\Group;
use App\Models\User;

class DocTypeController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * @var User
         */
        $user = auth()->user();
        $types = $user->documentTypes();
        $builder = DocType::orderby('name');
        if (count($types)) {
            $builder->whereIn('id', $types);
        }
        return response($builder->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DocType $docType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocTypeRequest $request, DocType $docType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocType $docType)
    {
        //
    }
}
