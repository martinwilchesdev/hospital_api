<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // obtener la lista completa de pacientes
        return response()->json(Paciente::orderBy('id', 'desc')->get());
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
        // validacion de datos
        $request->validate([
            'nombre'            => 'required|string|max:255',
            'documento'         => 'required|string|max:20|unique:pacientes,documento',
            'telefono'          => 'nullable|string|max:20',
            'direccion'         => 'nullable|date',
            'fecha_nacimiento'  => 'nullable|in:Masculino,Femenino,Otro'
        ]);

        // crear el paciente
        $paciente = Paciente::create($request->all());

        // devolver el paciente creado al front
        return response()->json($paciente);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paciente = Paciente::find($id);

        if (!$paciente) return response()->json(['mensaje' => 'Paciente no encontrado'], 404);

        return response()->json($paciente);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paciente $paciente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paciente $paciente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paciente $paciente)
    {
        //
    }
}
