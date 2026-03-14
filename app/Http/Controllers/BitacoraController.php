<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Actividad; // Importamos el modelo Actividad para la conexión


namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BitacoraController extends Controller
{
    public function index()
    {
        // Traemos los logs paginados
        $logs = Bitacora::with('user')->latest()->paginate(15);
        return view('admin.bitacora', compact('logs'));
    }

    /**
     * Store a newly created resource in storage.
     * Este método ahora crea el Log y la Notificación automáticamente.
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string',
        ]);

        // Llamamos a la función interna para procesar ambos registros
        $this->registrarEvento($request->descripcion);

        return back()->with('success', 'Evento registrado en bitácora y notificado.');
    }

    /**
     * Función centralizada para conectar Bitácora con Notificaciones
     */
    public function registrarEvento($descripcion)
    {
        // 1. Guardas en Bitácora
        $bitacora = Bitacora::create([
            'descripcion' => $descripcion,
            'user_id' => Auth::id(),
        ]);

        // 2. CONEXIÓN: Creas la notificación/actividad automáticamente
        Actividad::create([
            'titulo' => 'Nueva entrada en Bitácora',
            'mensaje' => 'El usuarios ' . Auth::user()->name . ' registró: ' . $descripcion,
            'user_id' => Auth::id(),
            'leido' => false,
        ]);

        return $bitacora;
    }

    // Los demás métodos se mantienen originales pero limpios
    public function create() { }
    public function show(string $id) { }
    public function edit(string $id) { }
    public function update(Request $request, string $id) { }
    public function destroy(string $id) { }
}
