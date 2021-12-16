<?php

namespace App\Http\Controllers;

use App\Models\Boardroom;
use Illuminate\Http\Request;

class BoardroomController extends Controller
{
    public function __construct()
    {
        //Protegemos el controlador con el middleware auth
        $this->middleware('auth');
    }

    // Listado de salas
    public function index()
    {
        $boardrooms = Boardroom::all();
        return view('boardrooms.index', compact('boardrooms'));
    }



   // Crear sala
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $boardroom = Boardroom::create($request->all());

        return redirect()->route('boardrooms.index')
            ->with('success', 'Sala fue creada con éxito');
    }



    // Mostrar formulario de edición
    public function edit($id)
    {
        $boardroom = Boardroom::find($id);
        return view('boardrooms.edit', compact('boardroom'));
    }

   // editar sala
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $boardroom = Boardroom::find($id);
        $boardroom->update($request->all());

        return redirect()->route('boardrooms.index')
            ->with('success', 'Sala fue actualizada con éxito');
    }

    //eliminar sala
    public function destroy($id)
    {
        $boardroom = Boardroom::find($id);
        $boardroom->delete();

        return redirect()->route('boardrooms.index')
            ->with('success', 'Sala fue eliminada con éxito');
    }
}
