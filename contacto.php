<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - PriceTracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include 'components/nav.php'; ?>

    <!-- Hero Section -->
    <header class="bg-indigo-700 text-white">
        <div class="container mx-auto px-4 py-16">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Contáctanos</h1>
            <p class="text-xl">Estamos aquí para ayudarte con tus necesidades de análisis de precios</p>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="container mx-auto px-4 py-12">
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Formulario de Contacto -->
            <div class="bg-white p-8 rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-6">Envíanos un mensaje</h2>
                <form action="procesar_contacto.php" method="POST" class="space-y-6">
                    <div>
                        <label for="nombre" class="block text-gray-700 mb-2">Nombre completo</label>
                        <input type="text" id="nombre" name="nombre" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-gray-700 mb-2">Correo electrónico</label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label for="asunto" class="block text-gray-700 mb-2">Asunto</label>
                        <input type="text" id="asunto" name="asunto" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500">
                    </div>
                    
                    <div>
                        <label for="mensaje" class="block text-gray-700 mb-2">Mensaje</label>
                        <textarea id="mensaje" name="mensaje" rows="5" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-indigo-500"></textarea>
                    </div>
                    
                    <button type="submit" 
                        class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700 transition duration-300">
                        Enviar Mensaje
                    </button>
                </form>
            </div>

            <!-- Información de Contacto -->
            <div class="space-y-8">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold mb-6">Información de Contacto</h2>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-map-marker-alt text-indigo-600 text-xl"></i>
                            <div>
                                <h3 class="font-semibold">Dirección</h3>
                                <p class="text-gray-600">Ciudad de México, México</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-phone text-indigo-600 text-xl"></i>
                            <div>
                                <h3 class="font-semibold">Teléfono</h3>
                                <p class="text-gray-600">+52 (55) 1234-5678</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-envelope text-indigo-600 text-xl"></i>
                            <div>
                                <h3 class="font-semibold">Email</h3>
                                <p class="text-gray-600">info@pricetracker.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Horario de Atención -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold mb-6">Horario de Atención</h2>
                    <div class="space-y-2">
                        <p class="flex justify-between">
                            <span class="font-semibold">Lunes - Viernes:</span>
                            <span class="text-gray-600">9:00 AM - 6:00 PM</span>
                        </p>
                        <p class="flex justify-between">
                            <span class="font-semibold">Sábado:</span>
                            <span class="text-gray-600">10:00 AM - 2:00 PM</span>
                        </p>
                        <p class="flex justify-between">
                            <span class="font-semibold">Domingo:</span>
                            <span class="text-gray-600">Cerrado</span>
                        </p>
                    </div>
                </div>

                <!-- Redes Sociales -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold mb-6">Síguenos</h2>
                    <div class="flex space-x-4">
                        <a href="#" class="text-indigo-600 hover:text-indigo-800">
                            <i class="fab fa-facebook-f text-2xl"></i>
                        </a>
                        <a href="#" class="text-indigo-600 hover:text-indigo-800">
                            <i class="fab fa-twitter text-2xl"></i>
                        </a>
                        <a href="#" class="text-indigo-600 hover:text-indigo-800">
                            <i class="fab fa-linkedin-in text-2xl"></i>
                        </a>
                        <a href="#" class="text-indigo-600 hover:text-indigo-800">
                            <i class="fab fa-instagram text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'components/footer.php'; ?>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>