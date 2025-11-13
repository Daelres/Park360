<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permiso;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AdminUsersController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Obtener roles: soporta Spatie (getRoleNames) o relación roles
        if ($user && method_exists($user, 'getRoleNames')) {
            $roles = $user->getRoleNames(); // Collection de nombres
        } elseif ($user && method_exists($user, 'roles')) {
            $user->loadMissing('roles');
            $roles = $user->roles->pluck('name');
        } else {
            $roles = collect();
        }

        // Determinar URL del avatar (ajustar según campo real en el modelo)
        $avatarUrl = $user->profile_photo_url ?? $user->avatar_url ?? asset('images/avatar-placeholder.png');

        return view('admin.users.myProfile', compact('user', 'roles', 'avatarUrl'));
    }

    /**
     * Vista de gestión de usuarios, roles y permisos.
     */
    public function manage()
    {
        $usuarios = User::with(['roles.permisos'])->orderBy('name')->get();
        $roles = Rol::orderBy('nombre')->get();
        $permisos = Permiso::orderBy('nombre')->get();

        return view('admin.users.index', [
            'usuarios' => $usuarios,
            'roles' => $roles,
            'permisos' => $permisos,
        ]);
    }

    /**
     * Asigna un rol existente a un usuario por nombre.
     */
    public function assignRole(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'rol' => ['required', 'string', 'exists:rol,nombre'],
        ]);

        $user->assignRole($validated['rol']);

        return back()->with('status', 'Rol asignado correctamente.');
    }

    /**
     * Crea un nuevo rol y le asigna permisos existentes.
     */
    public function storeRole(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:rol,nombre'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'permisos' => ['array'],
            'permisos.*' => ['integer', 'exists:permiso,id'],
        ]);

        $rol = Rol::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
        ]);

        if (!empty($validated['permisos'])) {
            $rol->permisos()->sync($validated['permisos']);
        }

        return back()->with('status', 'Rol creado correctamente.');
    }
}
