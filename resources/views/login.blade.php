@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-4">
        <!-- GRID PRINCIPAL DE 1 FILA Y 2 COLUMNAS -->
        <div class="grid grid-cols-2 gap-20 max-w-6xl w-full">

            <!-- COLUMNA IZQUIERDA: FORM + LOGO + BOTÓN -->
            <div class="flex items-center justify-center w-full">
                <div class="border border-gray-600 rounded-lg p-8 pt-0 relative w-full max-w-md">

                    <!-- LOGO -->
                    <div class="flex justify-center -mt-12 mb-8">
                        <img src="{{ asset('images/logo.svg') }}" alt="Katalyst Logo" class="w-24 h-24 rounded-2xl shadow-lg">
                    </div>

                    <!-- FORM -->
                    <form action="#" method="POST">
                        @csrf
                        <div class="w-full justify-center align-center">
                            <x-input name="Username" type="text" placeholder="Nombre de usuario" heigth="h-[50px]"
                                width="w-full" padding="p-[10px]" borderRadius="rounded-[10px]" />
                        </div>

                        <div class="w-full mt-4 justify-center align-center">
                            <x-input name="Password" type="password" placeholder="Contraseña" heigth="h-[50px]"
                                width="w-full" padding="p-[10px]" borderRadius="rounded-[10px]" />
                        </div>


                        <!-- BOTÓN ENTER -->
                        <div class="pt-4 flex justify-center">
                            <x-botones text="ENTER" type="button" color="#191919" size="md" height="small"
                                href="{{ route('prueba') }}" border_color="bg-[#191919]">
                            </x-botones>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- COLUMNA DERECHA: CAT_BOLA + TEXTO -->
    <div class="flex flex-col items-center justify-center">
        <div class="w-64 h-64 flex items-center justify-center opacity-80">
            <img src="{{ asset('images/cat_bola.svg') }}" alt="Gato con ovillo" class="w-full h-full object-contain">
        </div>
        <h2 class="text-gray-500 text-4xl font-bold tracking-wider">KATALYST</h2>
    </div>
@endsection
