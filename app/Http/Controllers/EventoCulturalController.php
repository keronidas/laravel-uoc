<?php

namespace App\Http\Controllers;

use App\Models\EventoCultural;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventoCulturalController extends Controller
{
    public function index()
    {
        // Obtener los dos eventos fijos
        $eventosFijos = EventoCultural::whereIn('nombre_evento', ['UFC 298', 'Otro Evento Fijo'])->get();

        // Obtener tres eventos aleatorios (excluyendo los eventos fijos)
        $eventosAleatorios = EventoCultural::whereNotIn('nombre_evento', ['UFC 298', 'Otro Evento Fijo'])
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('inicio', compact('eventosFijos', 'eventosAleatorios'));
    }

    public function show($id)
    {
        // Obtener el evento cultural por su ID
        $evento = EventoCultural::find($id);

        // Verificar si el evento existe
        if (!$evento) {
            // Puedes personalizar este mensaje de error según tus necesidades
            return abort(404, 'Evento no encontrado');
        }

        // Renderizar la vista "evento-unico.blade.php" y pasar el evento como variable
        return view('evento-unico', compact('evento'));
    }
    // Otras acciones del controlador, como 'show', pueden ir aquí
    public function getEventsPerPage($page)
    {
        // Calcular el límite y el desplazamiento para la paginación
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        // Consulta para obtener eventos en la página especificada
        $events = EventoCultural::select('id', 'nombre', 'fecha')
            ->skip($offset)
            ->take($perPage)
            ->get();

        return response()->json($events);
    }

    public function getEventById($id)
    {
        // Consulta para obtener el evento por su ID
        $event = EventoCultural::find($id);

        if (!$event) {
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }

        return response()->json($event);
    }
}
