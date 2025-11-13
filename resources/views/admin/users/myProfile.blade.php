{{-- blade --}}
@extends('layouts.app')

@section('content')
    <div class="d-flex" style="min-height:80vh;">
        {{-- Sidebar simple --}}
        <aside class="bg-light" style="width:220px;">
            <div class="p-4">
                <h4 class="text-primary">PARK <span class="text-secondary">360</span></h4>
            </div>
            <nav class="px-3">
                <ul class="list-unstyled">
                    <li class="mb-2"><small class="text-muted">Mi cuenta</small></li>
                    <li class="mb-2"><a class="text-dark" href="#">Perfil</a></li>
                    <li class="mt-4"><small class="text-muted">Panel Administrativo</small></li>
                </ul>
            </nav>
        </aside>

        {{-- Contenido principal --}}
        <main class="flex-grow-1 p-4">
            <div class="mb-4">
                <div class="py-2 px-3 rounded-pill text-white" style="background:#0d6efd; display:inline-block;">
                    <strong>Bienvenido Usuario!</strong>
                </div>
            </div>

            <div class="card p-4" style="font-size:1.05rem;">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h5 class="mb-1">Perfil</h5>
                        <small class="text-muted d-block mb-3">Gestiona tu perfil</small>

                        <div class="mb-2"><strong>Nombre Usuario</strong><div class="text-muted">{{ $user->name ?? '-' }}</div></div>
                        <div class="mb-2"><strong>Correo Electrónico</strong><div class="text-muted">{{ $user->email ?? '-' }}</div></div>

                        <div class="mb-2"><strong>Roles y permisos</strong>
                            <ul class="list-unstyled ms-3 mt-2">
                                @if(isset($roles) && $roles->count())
                                    @foreach($roles as $r)
                                        <li class="text-muted">-{{ $r }}</li>
                                    @endforeach
                                @else
                                    <li class="text-muted">- Sin roles asignados</li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4 text-center">
                        <div class="rounded" style="width:120px; height:120px; border:1px solid #e6e6e6; display:inline-flex; align-items:center; justify-content:center; overflow:hidden;">
                            <img src="{{ $avatarUrl }}" alt="Avatar" style="max-width:100%; max-height:100%; object-fit:cover;">
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
