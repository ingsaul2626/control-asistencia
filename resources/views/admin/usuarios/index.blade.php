<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestión de Permisos</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <table id="tablaPermisos" class="w-full border-collapse">
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
                                <span class="px-2 py-1 rounded text-xs {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : ($user->role === 'super_admin' ? 'bg-purple-100 text-purple-700' : 'bg-green-100 text-green-700') }}">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                            <td class="p-3 text-center">
                                @if($user->role !== 'super_admin')
                                    <form action="{{ route('admin.usuarios.toggle', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm font-bold {{ $user->role === 'admin' ? 'text-orange-600' : 'text-blue-600' }} hover:underline">
                                            {{ $user->role === 'admin' ? 'Quitar Admin' : 'Hacer Admin' }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-400 italic">Protegido</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function() {
        // Asegúrate de usar el mismo ID: tablaPermisos
        $('#tablaPermisos').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron usuarios",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ usuarios",
                "search": "Buscar usuario:",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "columnDefs": [
                { "orderable": false, "targets": 3 } // Desactivar orden en la columna de Acciones
            ],
            "pageLength": 10,
            "responsive": true,
            "dom": '<"flex justify-between items-center mb-4"lf>rt<"flex justify-between items-center mt-4"ip>'
        });
    });
    </script>
</x-app-layout>
