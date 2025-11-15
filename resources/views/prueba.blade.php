@extends('layouts.app')

@section('content')
    <x-botones text="mi boton"></x-botones>
    {{-- Resto del contenido --}}
    <x-input placeholder="mi input"></x-input>
    <x-fixedbar width="w-64" height="h-32" color="bg-white" rounded="rounded-xl" image="$image">
        <p class="text-black">Contenido de la tarjeta</p>
    </x-fixedbar>
@endsection
