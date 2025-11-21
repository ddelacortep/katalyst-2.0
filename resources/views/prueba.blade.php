@extends('layouts.app')

@section('content')
    <x-botones text="mi boton"></x-botones>
    {{-- Resto del contenido --}}
    <x-input placeholder="mi input"></x-input>
    <div>
        <x-fixedbar />
    </div>
@endsection

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

@foreach($tasks as $task)
    <div class="task">
        <h3>{{ $task->title }}</h3>
        <p>{{ $task->description }}</p>
        <p>Inicio: {{ $task->start_at }} — Fin: {{ $task->end_at }}</p>

        @if(!$task->google_event_id)
            <form action="{{ route('tasks.push-to-calendar', $task) }}" method="POST" style="display:inline">
                @csrf
                <button type="submit">Guardar en mi Google Calendar</button>
            </form>
        @else
            <a href="https://calendar.google.com/calendar/event?eid={{ urlencode($task->google_event_id) }}" target="_blank">Ver en Google Calendar</a>
        @endif
    </div>
@endforeach
