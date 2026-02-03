<?php

namespace App\Http\Controllers\Admin;
namespace App\Http\Controllers;
use App\Models\Evento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventoController extends Controller

{

    public function index()
{

        $eventos = Evento::all();
        return view('eventos.index', compact('eventos'));
}

   public function store(Request $request) {
    $request->validate(['titulo' => 'required', 'fecha' => 'required|date']);
    \App\Models\Evento::create($request->all());
    return back()->with('success', 'Evento publicado con éxito.');
    if (auth()->user()->role !== 'admin')
    abort(403, 'Acción no autorizada.');


    // ... lógica para guardar el evento
}

}
