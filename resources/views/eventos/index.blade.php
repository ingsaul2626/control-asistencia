<x-app-layout>
    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <p class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Bienvenido al panel de administración de eventos
                </p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                {{-- Mensajes de Error de Validación --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.proyectos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Título --}}
                        <div>
                            <label class="block text-sm font-bold text-zinc-700">Título del Proyecto</label>
                            <input type="text" name="titulo" class="w-full border-zinc-200 rounded-lg" value="{{ old('titulo') }}" required>
                        </div>

                        {{-- Trabajador --}}
                        <div>
                            <label class="block text-sm font-bold text-zinc-700">Asignar a Trabajador</label>
                            <select name="user_id" class="w-full border-zinc-200 rounded-lg" required>
                                <option value="">Seleccione un responsable...</option>
                                @foreach($usuarios as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Fecha --}}
                        <div>
                            <label class="block text-sm font-bold text-zinc-700">Fecha del Evento</label>
                            <input type="date" name="fecha" class="w-full border-zinc-200 rounded-lg" value="{{ old('fecha') }}" required>
                        </div>

                        {{-- Lugar --}}
                        <div>
                            <label class="block text-sm font-bold text-zinc-700">Lugar</label>
                            <input type="text" name="lugar" class="w-full border-zinc-200 rounded-lg" value="{{ old('lugar') }}" placeholder="Ej: Auditorio Central">
                        </div>

                        {{-- TIPO DE PROYECTO (Campo faltante corregido) --}}
                        <div>
                            <label class="block text-sm font-bold text-zinc-700">Tipo de Proyecto</label>
                            <select name="tipo" class="w-full border-zinc-200 rounded-lg" required>
                                <option value="">Seleccione tipo...</option>
                                <option value="Obra" {{ old('tipo') == 'Obra' ? 'selected' : '' }}>Obra</option>
                                <option value="Mantenimiento" {{ old('tipo') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                <option value="Reparación" {{ old('tipo') == 'Reparación' ? 'selected' : '' }}>Reparación</option>
                                <option value="Diseño" {{ old('tipo') == 'Diseño' ? 'selected' : '' }}>Diseño</option>
                            </select>
                        </div>

                        {{-- Archivo PDF (Plano) --}}
                        <div>
                            <label class="block text-sm font-bold text-zinc-700">Documentación Técnica (PDF)</label>
                            <input type="file" name="archivo" accept="application/pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>

                        {{-- Imagen --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-zinc-700">Imagen del Proyecto</label>
                            <input type="file" name="imagen" accept="image/*" class="w-full" required>

                            <div class="mt-2">
                                <input type="checkbox" name="publicado" value="1" id="pub" {{ old('publicado') ? 'checked' : '' }}>
                                <label for="pub" class="text-sm">Publicar en la página de inicio</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Detalles Técnicos / Descripción</label>
                        <textarea name="descripcion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Escribe aquí los detalles específicos...">{{ old('descripcion') }}</textarea>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded shadow hover:bg-indigo-700 transition">
                            Asignar Responsable y Detalles
                        </button>
                    </div>
                </form>

                <hr class="my-8">

                <div class="overflow-x-auto">
                    <table id="miTablaGenerica" class="display w-full text-left border-collapse">
                        <thead>
                            <tr class="text-gray-700 border-b">
                                <th class="py-2">Título</th>
                                <th class="py-2">Tipo</th>
                                <th class="py-2">Fecha</th>
                                <th class="py-2">Estado</th>
                                <th class="py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eventos as $evento)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 font-medium">{{ $evento->titulo }}</td>
                                <td class="py-3 text-xs uppercase text-gray-500">{{ $evento->tipo }}</td>
                                <td class="py-3">{{ $evento->fecha }}</td>
                                <td class="py-3">
                                    <span class="px-2 py-1 rounded-full text-xs {{ $evento->activo ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                        {{ $evento->activo ? 'Visible' : 'Oculto' }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div class="flex items-center">
                                        <a href="{{ route('admin.proyectos.edit', $evento) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                        <form action="{{ route('admin.proyectos.destroy', $evento) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#miTablaGenerica').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            },
            "responsive": true,
            "pageLength": 10,
            "order": [[2, "desc"]]
        });
    });
    </script>
</x-app-layout>
