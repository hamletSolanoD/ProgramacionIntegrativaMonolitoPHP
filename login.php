<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-center mb-6">Iniciar Sesión</h1>
        <form action="procesar_login.php" method="POST" class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Correo Electrónico</label>
                <input type="email" id="email" name="email" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>