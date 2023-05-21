<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Resources\PermissionsResource;
use App\Http\Resources\PermissionTreeResource;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Permissions/Index', [
            'permissions' => Permission::defaultOrder()->get()
        ]);
    }

    public function getTree()
    {
        return PermissionTreeResource::collection(Permission::get()->toTree());
    }

    public function getAllPermissions(Request $request)
    {
        return PermissionsResource::collection(Permission::defaultOrder()->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Permissions/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'name' => $request->input('name')
        ];

        if ($request->input('parent')) {
            $parent = Permission::where('uuid', $request->input('parent'))->first();
            $data['parent_id'] = $parent->id;
        }
        $permission = Permission::create($data);
        return redirect()->route('permissoes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
