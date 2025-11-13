<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
