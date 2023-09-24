<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocImageRequest;
use App\Http\Requests\UpdateDocImageRequest;
use App\Models\DocImage;
use App\Models\Document;
use Illuminate\Http\Request;

class DocImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $builder = DocImage::orderBy('id');
        return response($builder->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocImageRequest $request)
    {
        $data = $request->validated();
        $document = Document::findOrFail($data['document_id']);
        $path = sprintf('images/%s', $document->id);
        $data['filename'] =  $request->file('file')->store($path, 'public');
        $image = new DocImage($data);
        $image->save();
        return response($image, 201);
    }

    public function multiple(Request $request)
    {
        $request->validate([
            'document_id' => 'required|exists:documents,id',
            'files' => 'required|image|mimes:jpeg,jpg,png,svg,pdf,tiff',
        ]);

        $document = Document::findOrFail($request->get('document_id'));
        $path = sprintf('images/%s', $document->id);
        return response($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(DocImage $docImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocImageRequest $request, DocImage $docImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocImage $docImage)
    {
        //
    }
}
