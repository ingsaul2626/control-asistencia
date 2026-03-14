<x-guest-layout>
    <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl border border-slate-100 p-10 text-center">
        <div class="text-amber-500 mb-6">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h2 class="text-2xl font-black text-slate-800 uppercase">Cuenta en Revisión</h2>

        <p class="mt-4 text-slate-600 text-sm">
            @auth
                Hola <strong>{{ auth()->user()->name }}</strong>, tus datos están siendo validados por un administrador.
            @else
                Hola, usuarios, tus datos están siendo validados por un administrador.
            @endauth
        </p>

        <form method="POST" action="{{ route('logout') }}" class="mt-8">
            @csrf
            <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3 rounded-xl hover:bg-slate-800 transition-all">
                Cerrar Sesión
            </button>
        </form>
    </div>
</x-guest-layout>
