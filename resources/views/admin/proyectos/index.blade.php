<table id="miTablaGenerica" class="display w-full">
    <thead>
        <tr class="text-gray-700 border-b bg-gray-50">
            <th class="py-3 px-4">Proyecto</th>
            <th class="py-3 px-4">Responsable</th>
            <th class="py-3 px-4">Avance Técnico (Reporte)</th>
            <th class="py-3 px-4">Estado</th>
            <th class="py-3 px-4">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($eventos as $evento)
        <tr class="border-b hover:bg-indigo-50/30 transition">
            <td class="py-4 px-4">
                <div class="font-bold text-indigo-900">{{ $evento->titulo }}</div>
                <div class="text-[10px] text-gray-400 uppercase">{{ $evento->tipo }} | {{ $evento->lugar }}</div>
            </td>
            <td class="py-4 px-4 text-sm text-gray-600">
                {{ $evento->user->name ?? 'Sin asignar' }}
            </td>
            <td class="py-4 px-4">
                @if($evento->reporte_trabajador)
                    <div class="group relative cursor-help">
                        <p class="text-xs text-gray-700 bg-amber-50 p-2 rounded border border-amber-200 line-clamp-2 italic">
                            "{{ $evento->reporte_trabajador }}"
                        </p>
                        {{-- Tooltip al pasar el mouse --}}
                        <div class="hidden group-hover:block absolute z-10 w-64 p-3 bg-gray-900 text-white text-xs rounded-lg shadow-xl -mt-2">
                            {{ $evento->reporte_trabajador }}
                        </div>
                    </div>
                @else
                    <span class="text-xs text-gray-400 italic">Esperando reporte...</span>
                @endif
            </td>
            <td class="py-4 px-4">
                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $evento->activo ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                    {{ $evento->activo ? 'Activo' : 'Pausado' }}
                </span>
            </td>
            <td class="py-4 px-4">
                <div class="flex items-center gap-2">
                    {{-- BOTÓN VER DETALLES (SHOW) --}}
                    <a href="{{ route('admin.proyectos.show', $evento->id) }}"
                       class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white rounded-md text-[10px] font-bold hover:bg-indigo-700 transition uppercase shadow-sm">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Ver Detalle
                    </a>

                    {{-- BOTÓN EDITAR --}}
                    <a href="{{ route('admin.proyectos.edit', $evento->id) }}"
                       class="p-1.5 bg-blue-50 text-blue-600 rounded-md hover:bg-blue-600 hover:text-white transition shadow-sm" title="Editar">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
