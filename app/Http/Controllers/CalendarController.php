<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Log;
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
        // Evitar duplicados: si ya tiene google_event_id, no crear otra vez
        if ($task->google_event_id) {
            return back()->with('status', 'Ya existe evento en Google Calendar para esta tarea.');
        }

        // Crear evento
        $service = $this->gcal->service();

        Log::info('1');

        // Limpia el formato de las fechas para evitar errores de parsing
        $fecha_creacion = str_replace(':AM', ' AM', $task->fecha_creacion);
        $fecha_creacion = str_replace(':PM', ' PM', $fecha_creacion);
        $fecha_limite = str_replace(':AM', ' AM', $task->fecha_limite);
        $fecha_limite = str_replace(':PM', ' PM', $fecha_limite);

        // Prepara fecha/hora en formato RFC3339
        $start = Carbon::parse($fecha_creacion)->toRfc3339String();
        $end   = Carbon::parse($fecha_limite)->toRfc3339String();

        Log::info('2');

        $event = new Google_Service_Calendar_Event([
            'summary' => $task->nombre_tarea,
            'description' => $task->desc_tarea,
            'start' => ['dateTime' => $start, 'timeZone' => config('app.timezone', 'UTC')],
            'end' => ['dateTime' => $end, 'timeZone' => config('app.timezone', 'UTC')],
        ]);

        Log::info('3');

        $calendarId = env('GOOGLE_CALENDAR_ID'); // tu calendario
        $createdEvent = $service->events->insert($calendarId, $event);

        Log::info('4');
        $eid = base64_encode($createdEvent->getId() . ' ' . $calendarId);
        $url = 'https://calendar.google.com/calendar/u/0/event?eid=' . $eid;


        // Guarda google_event_id en la tarea para evitar duplicados
        $task->google_event_id = $createdEvent->getId();
        $task->calendar_url = $url;
        $task->save();


        return redirect()->route('proyecto.show', $task->id_proyecto)
            ->with('status', 'Evento creado en Google Calendar');
    }
}
