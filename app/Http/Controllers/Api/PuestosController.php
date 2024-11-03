<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Puesto;
use Illuminate\Http\Request;

class PuestosController extends Controller
{

    // Método para obtener todos los puestos
    public function index(){
        $puestos = Puesto::all();

        if ($puestos->isEmpty()) {
            return response()->json(['message' => 'No hay puestos registrados'], 404);
        }

        return response()->json($puestos, 200);
    }

    // Método para crear un nuevo puesto

    public function create(Request $request){
        $request->validate([
            'nombre_del_puesto' => 'required|string|max:255',
        ]);

        $puesto = Puesto::create([
            'nombre_del_puesto' => $request->nombre_del_puesto,
        ]);

        if ($puesto) {
            return response()->json($puesto, 201);
        } else {
            return response()->json([
                'message' => 'No se pudo crear el puesto. Inténtalo de nuevo más tarde.'
            ], 500);
        }
    }

    // Método para obtener un puesto por su ID

    public function show($id){
        $puesto = Puesto::find($id);

        if ($puesto) {
            return response()->json($puesto, 200);
        } else {
            return response()->json(['message' => 'Puesto no encontrado'], 404);
        }
    }

    // Método para actualizar un puesto

    public function update(Request $request, $id){
        $request->validate([
            'nombre_del_puesto' => 'required|string|max:255',
        ]);

        $puesto = Puesto::find($id);

        if ($puesto) {
            $puesto->nombre_del_puesto = $request->nombre_del_puesto;
            $puesto->save();

            return response()->json($puesto, 200);
        } else {
            return response()->json(['message' => 'Puesto no encontrado'], 404);
        }
    }

    public function destroy($id){
        $puesto = Puesto::find($id);

        if ($puesto) {
            $puesto->delete();

            return response()->json(['message' => 'Puesto eliminado'], 200);
        } else {
            return response()->json(['message' => 'Puesto no encontrado'], 404);
        }
    }
}
