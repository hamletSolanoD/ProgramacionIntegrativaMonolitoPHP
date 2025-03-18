<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Tu Tienda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-lg mx-auto">
            <a href="index.php" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">
                ← Volver al inicio
            </a>
            
            <div class="bg-white p-8 rounded-xl shadow-lg">
                <h1 class="text-3xl font-bold text-center mb-2">Crear una Cuenta</h1>
                <p class="text-gray-600 text-center mb-6">Únete a nuestra comunidad de compradores</p>

                <div id="mensajeError" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4"></div>
                <div id="mensajeExito" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"></div>

                <form id="registroForm" action="procesar_signup.php" method="POST" class="space-y-6">
                    <div>
                        <label for="nombre" class="block text-gray-700 font-medium mb-2">Nombre completo</label>
                        <input type="text" id="nombre" name="nombre" required 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="Ej: Juan Pérez">
                        <p class="text-sm text-gray-500 mt-1">Mínimo 3 caracteres</p>
                    </div>

                    <div>
                        <label for="email" class="block text-gray-700 font-medium mb-2">Correo Electrónico</label>
                        <input type="email" id="email" name="email" required 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="tucorreo@ejemplo.com">
                        <p id="emailFeedback" class="text-sm text-gray-500 mt-1">Usarás este email para iniciar sesión</p>
                    </div>

                    <div>
                        <label for="password" class="block text-gray-700 font-medium mb-2">Contraseña</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required 
                                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                   placeholder="Mínimo 8 caracteres">
                            <button type="button" id="togglePassword" class="absolute right-3 top-2.5 text-gray-500">
                                👁️
                            </button>
                        </div>
                        <div class="mt-2">
                            <div id="passwordStrength" class="h-2 rounded-full bg-gray-200"></div>
                            <p id="passwordFeedback" class="text-sm text-gray-500 mt-1">La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas y números</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="terminos" name="terminos" required class="h-4 w-4 text-indigo-600">
                        <label for="terminos" class="ml-2 text-sm text-gray-700">
                            Acepto los <a href="#" class="text-indigo-600 hover:underline">términos y condiciones</a>
                        </label>
                    </div>

                    <button type="submit" id="submitBtn" 
                            class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center justify-center">
                        <span>Crear cuenta</span>
                        <div id="loadingSpinner" class="hidden ml-3">
                            <!-- Spinner SVG aquí -->
                        </div>
                    </button>

                    <p class="text-center text-sm text-gray-600">
                        ¿Ya tienes una cuenta? 
                        <a href="login.php" class="text-indigo-600 hover:underline">Inicia sesión</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Toggle password visibility
        $('#togglePassword').click(function() {
            const passwordInput = $('#password');
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).text(type === 'password' ? '👁️' : '👁️‍🗨️');
        });

        // Password strength checker
        $('#password').on('input', function() {
            const password = $(this).val();
            let strength = 0;
            let feedback = [];

            if (password.length >= 8) strength += 25;
            if (password.match(/[A-Z]/)) strength += 25;
            if (password.match(/[a-z]/)) strength += 25;
            if (password.match(/[0-9]/)) strength += 25;

            // Update strength indicator
            $('#passwordStrength').css('width', strength + '%');
            if (strength <= 25) {
                $('#passwordStrength').css('background-color', '#ef4444');
            } else if (strength <= 50) {
                $('#passwordStrength').css('background-color', '#f59e0b');
            } else if (strength <= 75) {
                $('#passwordStrength').css('background-color', '#10b981');
            } else {
                $('#passwordStrength').css('background-color', '#059669');
            }
        });

        // Email validation
        $('#email').on('blur', function() {
            const email = $(this).val();
            if (email) {
                $.post('validar_email.php', {email: email}, function(response) {
                    if (response.disponible) {
                        $('#emailFeedback').text('Email disponible').removeClass('text-red-500').addClass('text-green-500');
                    } else {
                        $('#emailFeedback').text('Este email ya está registrado').removeClass('text-green-500').addClass('text-red-500');
                    }
                });
            }
        });

        // Form submission
        $('#registroForm').on('submit', function(e) {
            e.preventDefault();
            
            $('#submitBtn span').text('Creando cuenta...');
            $('#loadingSpinner').removeClass('hidden');

            $.ajax({
                url: 'procesar_signup.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#mensajeExito').removeClass('hidden').text('¡Cuenta creada exitosamente! Redirigiendo...');
                        setTimeout(() => window.location.href = 'index.php', 2000);
                    } else {
                        $('#mensajeError').removeClass('hidden').text(response.message);
                    }
                },
                error: function() {
                    $('#mensajeError').removeClass('hidden').text('Error al crear la cuenta. Por favor, intenta nuevamente.');
                },
                complete: function() {
                    $('#submitBtn span').text('Crear cuenta');
                    $('#loadingSpinner').addClass('hidden');
                }
            });
        });
    });
    </script>
</body>
</html>