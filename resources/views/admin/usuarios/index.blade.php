<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestión de Permisos</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 text-left">Nombre</th>
                            <th class="p-3 text-left">Correo</th>
                            <th class="p-3 text-left">Rol Actual</th>
                            <th class="p-3 text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $user)
                        <tr class="border-b">
                            <td class="p-3">{{ $user->name }}</td>
                            <td class="p-3">{{ $user->email }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-xs {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td class="p-3 text-center">
                                <form action="{{ route('admin.usuarios.toggle', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-sm font-bold {{ $user->role === 'admin' ? 'text-orange-600' : 'text-blue-600' }}">
                                        {{ $user->role === 'admin' ? 'Quitar Admin' : 'Hacer Admin' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
