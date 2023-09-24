<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\User;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * @var User
         */
        $user = auth()->user();
        $departments = $user->departments();
        $builder = Department::whereNot('name', 'System')
            ->orderby('name');
        if (count($departments)) {
            $builder->whereIn('id', $departments);
        }
        return response($builder->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request)
    {
        $department = new Department($request->all());
        $department->save();
        return response($department, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return response($department);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->update($request->all());
        return response($department);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return response([], 204);
    }
}
