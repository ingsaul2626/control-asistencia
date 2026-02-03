<div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 transition hover:shadow-lg">
    <div class="h-40 bg-gray-200">
        @if($evento->imagen)
            <img src="{{ asset('storage/' . $evento->imagen) }}" class="w-full h-full object-cover">
        @endif
    </div>
    <div class="p-4">
        <h3 class="text-lg font-bold text-gray-800">{{ $evento->titulo }}</h3>
        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($evento->descripcion, 100) }}</p>

        <div class="flex justify-between items-center text-xs text-gray-500">
            <span><i class="far fa-calendar"></i> {{ $evento->fecha }}</span>
            <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded">{{ $evento->lugar }}</span>
        </div>

        <div class="mt-4 pt-3 border-t border-gray-100">
            {{ $slot }}
        </div>
    </div>
</div>
