@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Detalles del Usuario</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="mb-4">
            <strong class="block text-sm font-medium text-gray-700">Nombre:</strong>
            <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
        </div>

        <div class="mb-4">
            <strong class="block text-sm font-medium text-gray-700">Email:</strong>
            <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
        </div>

        <div class="mb-4">
            <strong class="block text-sm font-medium text-gray-700">Rol:</strong>
            <p class="mt-1 text-sm text-gray-900">{{ ucfirst($user->role) }}</p>
        </div>

        <div class="mb-4">
            <strong class="block text-sm font-medium text-gray-700">Fecha de Creación:</strong>
            <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="flex items-center space-x-4">
            <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver
            </a>
            <a href="{{ route('users.edit', $user) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Editar
            </a>
        </div>
    </div>
</div>
@endsection