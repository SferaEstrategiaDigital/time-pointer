<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertSystemUser;
use App\Http\Requests\UpdateSystemUser;
use App\Models\User;
use Illuminate\Http\Request;

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
        User::create($request->validated());
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
            'usuario' => $usuario
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
