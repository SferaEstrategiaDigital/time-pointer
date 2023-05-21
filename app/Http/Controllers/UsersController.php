<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\InsertSystemUser;
use App\Http\Requests\UpdateSystemUser;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Users/Index', [
            'users' => User::get()
        ]);
    }

    public function create(Request $request)
    {
        return inertia('Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InsertSystemUser $request)
    {
        $usuario = User::create($request->validated());
        $roles = Role::whereIn('uuid', $request->input('roles'))->get();
        $usuario->syncRoles($roles);
        return redirect()->route('usuarios.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    public function edit(User $usuario)
    {
        return inertia('Users/Edit', [
            'usuario' => new UserResource($usuario)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSystemUser $request, User $usuario)
    {
        $validatedData = $request->validated();
        if (empty($validatedData['password'])) {
            unset($validatedData['password']);
        }
        $usuario->update($validatedData);
        $roles = Role::whereIn('uuid', $request->input('roles'))->get();
        $usuario->syncRoles($roles);
        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('usuarios.index');
    }
}
