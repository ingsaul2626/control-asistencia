<?php

namespace App\Http\Controllers;

use App\Models\Bitacora; // Asegúrate de tener el modelo
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    public function index()
    {
        // Traemos los logs paginados
       $logs = \App\Models\Bitacora::with('user')->latest()->paginate(15);
    return view('admin.bitacora', compact('logs'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
