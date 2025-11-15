@extends('layouts.app')

@section('content')
    <x-fixedbar />

    <div class="ml-[91px] mr-[6px] mt-[150px] mb-[6px]">
        <x-proyectocontenido flex="flex justify-between">
            <div class="flex justify-start">
                <x-botones text="Filtro" type="button" color="#F4F4F4" text_color="#000000" size="md" height="normal"
                    href="{{ route('prueba') }}">
                </x-botones>
            </div>
            <div class="flex justify-end">
                <x-botones text="+ Tarea" type="button" color="#F4F4F4" text_color="#000000" border_color="#8b5cf6"
                    size="md" height="normal" href="{{ route('prueba') }}">
                </x-botones>
            </div>
        </x-proyectocontenido>
    </div>
@endsection
