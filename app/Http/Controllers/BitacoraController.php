<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Actividad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BitacoraController extends Controller
{
    public function index()
    {
        // Traemos la información paginada para la vista

        $bitacoras = Bitacora::with('user')->latest()->paginate(15);
       return view('admin.bitacora', [
        'bitacoras' => $bitacoras,
        'logs' => $bitacoras
    ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'accion' => 'required|string',
            'detalles' => 'required|string',
        ]);

        // Pasamos ambos argumentos a la función
        $this->registrarEvento($request->accion, $request->detalles);

        return back()->with('success', 'Actividad de proyecto registrada en bitácora.');
    }

    public function registrarEvento($accion, $detalles)
    {
        // Guardamos usando los campos reales de tu tabla (accion y detalles)
        $bitacora = Bitacora::create([
            'user_id'  => Auth::id(),
            'accion'   => $accion,
            'detalles' => $detalles,
            'ip'       => request()->ip(),
        ]);

        // Opcional: Registrar en la tabla Actividad si aún la usas
        Actividad::create([
            'titulo' => 'Actualización de Proyecto',
            'mensaje' => 'El usuario ' . Auth::user()->name . ' registró: ' . $accion,
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
