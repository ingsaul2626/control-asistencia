<x-app-layout>
    
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-4">Editar Proyecto: {{ $proyecto->titulo }}</h2>

                <form action="{{ route('admin.proyectos.update', $proyecto->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block font-medium">Título</label>
                            <input type="text" name="titulo" value="{{ $proyecto->titulo }}" class="w-full border-gray-300 rounded-md" required>
                        </div>

                        <div>
                            <label class="block font-medium">Asignar a Trabajador</label>
                            <select name="user_id" class="w-full border-gray-300 rounded-md">
                                @foreach($usuarios as $user)
                                    <option value="{{ $user->id }}" {{ $proyecto->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-medium">Imagen Actual</label>
                            <img src="{{ asset('storage/' . $proyecto->imagen) }}" class="w-20 h-20 mb-2 rounded">
                            <input type="file" name="imagen" class="w-full">
                        </div>

                        <div>
                            <label class="block font-medium">Archivo PDF (Plano)</label>
                            @if($proyecto->archivo)
                                <span class="text-sm text-green-600">Ya existe un archivo subido</span>
                            @endif
                            <input type="file" name="archivo" class="w-full">
                        </div>

                        <div class="mt-4 flex gap-2">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar</button>
                            <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
