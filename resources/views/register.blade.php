@extends('layouts.app')

@section('content')
<div class="bg-[#222222] min-h-screen flex items-center justify-center p-4">
    <div class="flex items-center justify-between gap-20 max-w-6xl w-full">
        <!-- Formulario de registro -->
        <div class="w-96">
            <div class="border border-gray-600 rounded-lg p-8 pt-0 relative">
                <div class="flex justify-center -mt-12 mb-8">
                    <img src="{{ asset('images/logo.svg') }}" alt="Katalyst Logo" class="w-24 h-24 rounded-2xl shadow-lg">
                </div>

                <form action="#" method="POST" class="space-y-5">
                    @csrf

                    <x-input
                        name="username"
                        type="text"
                        placeholder="Nombre de usuario"
                        width="w-full"
                        heigth="h-auto"
                        padding="p-3"
                        borderRadius="rounded-lg"
                        backgroundColor="bg-[#191919]"
                        border_color="#3a3a3a"
                    />

                    <x-input
                        name="email"
                        type="email"
                        placeholder="Mail"
                        width="w-full"
                        heigth="h-auto"
                        padding="p-3"
                        borderRadius="rounded-lg"
                        backgroundColor="bg-[#191919]"
                        border_color="#3a3a3a"
                    />

                    <x-input
                        name="password"
                        type="password"
                        placeholder="Contraseña"
                        width="w-full"
                        heigth="h-auto"
                        padding="p-3"
                        borderRadius="rounded-lg"
                        backgroundColor="bg-[#191919]"
                        border_color="#3a3a3a"
                    />

                    <x-input
                        name="password_confirmation"
                        type="password"
                        placeholder="Confirmar contraseña"
                        width="w-full"
                        heigth="h-auto"
                        padding="p-3"
                        borderRadius="rounded-lg"
                        backgroundColor="bg-[#191919]"
                        border_color="#3a3a3a"
                    />

                    <div class="pt-4 flex justify-center">
                        <x-botones
                            text="Confirmar"
                            type="submit"
                            color="#8b5cf6"
                            border_color="#8b5cf6"
                            size="lg"
                            height="normal"
                        />
                    </div>
                </form>
            </div>
        </div>

        <!-- Bloque de imagen + texto KATALYST -->
        <div class="flex flex-col items-center gap-6">
            <div class="w-64 h-64 flex items-center justify-center opacity-80">
                <img src="{{ asset('images/cat_bola.svg') }}" alt="Gato con ovillo" class="w-full h-full object-contain">
            </div>
            <h2 class="text-gray-500 text-4xl font-bold tracking-wider">KATALYST</h2>
        </div>

    </div>
</div>
@endsection