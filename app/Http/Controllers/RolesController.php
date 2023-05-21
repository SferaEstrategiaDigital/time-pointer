<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Resources\RolesResource;
use App\Http\Resources\PermissionTreeResource;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Roles/Index', [
            'roles' => Role::get()
        ]);
    }

    public function getAllRoles(Request $request)
    {
        return RolesResource::collection(Role::get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Roles/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->input('name')]);
        $perms = Permission::whereIn('uuid', $request->input('permissions'))->get();
        $role->givePermissionTo($perms);

        return redirect()->route('funcoes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
