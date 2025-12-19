<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\GoogleCalendarService;
use Google_Service_Calendar_EventDateTime;

class CalendarController extends Controller
{
    protected $gcal;

    public function __construct(GoogleCalendarService $gcal)
    {
        $this->gcal = $gcal;
    }

    public function pushTaskToCalendar(Request $request, Tarea $task)
    {
        $user = Auth::user();

        // Verificar que el usuario tiene Google Calendar conectado
        if (!$user->hasGoogleCalendarConnected()) {
            return redirect()->route('google.auth')
                ->with('info', 'Primero necesitas conectar tu cuenta de Google Calendar.');
        }

        // Evitar duplicados: si ya tiene google_event_id, no crear otra vez
        if ($task->google_event_id) {
            return back()->with('status', 'Ya existe evento en Google Calendar para esta tarea.');
        }

        try {
            // Crear evento usando el servicio con el usuario actual
            $service = $this->gcal->service();

            Log::info('Creando evento en Google Calendar para tarea: ' . $task->id);

            // Limpia el formato de las fechas para evitar errores de parsing
            $fecha_creacion = str_replace(':AM', ' AM', $task->fecha_creacion);
            $fecha_creacion = str_replace(':PM', ' PM', $fecha_creacion);
            $fecha_limite = str_replace(':AM', ' AM', $task->fecha_limite);
            $fecha_limite = str_replace(':PM', ' PM', $fecha_limite);

            // Prepara fecha/hora en formato RFC3339
            $start = Carbon::parse($fecha_creacion)->toRfc3339String();
            $end   = Carbon::parse($fecha_limite)->toRfc3339String();

            $event = new Google_Service_Calendar_Event([
                'summary' => $task->nombre_tarea,
                'description' => $task->desc_tarea,
                'start' => ['dateTime' => $start, 'timeZone' => config('app.timezone', 'UTC')],
                'end' => ['dateTime' => $end, 'timeZone' => config('app.timezone', 'UTC')],
            ]);

            // Usar 'primary' para el calendario principal del usuario autenticado
            // Esto funciona para cualquier cuenta de Google vinculada
            $calendarId = 'primary';
            $createdEvent = $service->events->insert($calendarId, $event);

            Log::info('Evento creado con ID: ' . $createdEvent->getId());

            // Generar URL del evento
            $eid = base64_encode($createdEvent->getId() . ' ' . $calendarId);
            $url = 'https://calendar.google.com/calendar/event?eid=' . urlencode($eid);

            // Guarda google_event_id en la tarea para evitar duplicados
            $task->google_event_id = $createdEvent->getId();
            $task->calendar_url = $createdEvent->getHtmlLink(); // URL directa del evento
            $task->save();

            return redirect()->route('proyecto.show', $task->id_proyecto)
                ->with('status', 'Evento creado en tu Google Calendar');

        } catch (\Exception $e) {
            Log::error('Error creando evento en Google Calendar: ' . $e->getMessage());
            
            // Si el token expiró o hay error de autenticación, redirigir a reconectar
            if (str_contains($e->getMessage(), 'caducado') || str_contains($e->getMessage(), 'vinculado')) {
                return redirect()->route('google.auth')
                    ->with('error', $e->getMessage());
            }

            return back()->with('error', 'Error al crear evento en Google Calendar: ' . $e->getMessage());
        }
    }
}
