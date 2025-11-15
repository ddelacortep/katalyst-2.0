<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Katalyst</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#222222] min-h-screen flex items-center justify-center p-4">
    <div class="flex items-center gap-20 max-w-6xl">
        <!-- Formulario de login -->
        <div class="w-96">
            <!-- Contenedor con borde -->
            <div class="border border-gray-600 rounded-lg p-8 pt-0 relative">
                <!-- Logo del gato (sale del contenedor) -->
                <div class="flex justify-center -mt-12 mb-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Katalyst Logo" class="w-24 h-24 rounded-2xl shadow-lg">
                </div>

                <form action="#" method="POST" class="space-y-5">
                    @csrf
                    
                    <div>
                        <x-input 
                            name="username"
                            type="text"
                            placeholder="Nombre de usuario"
                            size="md"
                            height="normal"
                        />
                    </div>

                    <
                    <div>
                        <x-input 
                            name="password"
                            type="password"
                            placeholder="Contraseña"
                            size="md"
                            height="normal"
                        />
                    </div>

                  
                    <div class="pt-4 flex justify-center">
                        <x-botones 
                            text="ENTER"
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

        <!-- Sección derecha: Gato con ovillo y texto KATALYST -->
        <div class="flex flex-col items-center gap-6">
            <!-- Ilustración del gato con ovillo -->
            <div class="w-64 h-64 flex items-center justify-center opacity-80">
                <img src="{{ asset('images/cat_bola.svg') }}" alt="Gato con ovillo" class="w-full h-full object-contain">
            </div>
            
            <!-- Texto KATALYST -->
            <h2 class="text-gray-500 text-4xl font-bold tracking-wider">KATALYST</h2>
        </div>
    </div>
</body>
</html>
