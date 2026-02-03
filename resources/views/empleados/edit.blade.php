<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Trabajador: ') }} {{ $empleado->nombre_apellido }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-3 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-100 p-6">

                <form action="{{ route('admin.empleados.update', $empleado->id) }}"
                      method="POST"
                      id="update-form"
                      onsubmit="return confirm('¿Estás seguro de que deseas actualizar los datos de este trabajador?')">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Cédula</label>
                            <input type="text" name="cedula"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                maxlength="8"
                                value="{{ old('cedula', $empleado->cedula) }}"
                                placeholder="Cédula del trabajador"
                                class="w-full rounded-md border-gray-300" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre y Apellido</label>
                            <input type="text" name="nombre_apellido"
                                oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ ]/g, '')"
                                value="{{ old('nombre_apellido', $empleado->nombre_apellido) }}"
                                placeholder="Ej: Juan Perez"
                                class="w-full rounded-md border-gray-300" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tipo de Trabajador</label>
                            <select name="tipo_trabajador" class="w-full rounded-md border-gray-300 shadow-sm">
                                <option value="ADM/FIJO" {{ $empleado->tipo_trabajador == 'ADM/FIJO' ? 'selected' : '' }}>ADM/FIJO</option>
                                <option value="ADM/CONT" {{ $empleado->tipo_trabajador == 'ADM/CONT' ? 'selected' : '' }}>ADM/CONT</option>
                                <option value="DOC/ORDINARIO" {{ $empleado->tipo_trabajador == 'DOC/ORDINARIO' ? 'selected' : '' }}>DOC/ORDINARIO</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Sección</label>
                            <input type="text" name="seccion"
                                   value="{{ old('seccion', $empleado->seccion) }}"
                                   class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 space-x-3">
                        <a href="{{ route('admin.empleados.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-bold text-xs text-black uppercase tracking-widest hover:bg-gray-300 transition ease-in-out duration-150">
                            {{ __('Volver Listado') }}
                        </a>

                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold" onclick="disableButton(this)">
                            {{ __('Actualizar Trabajador') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function disableButton(btn) {
        // Pequeño delay para permitir que el onsubmit del form se ejecute primero
        setTimeout(() => {
            if (btn.form.checkValidity()) {
                btn.disabled = true;
                btn.innerText = 'Procesando...';
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }, 50);
    }
</script>
