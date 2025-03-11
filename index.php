<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios eCommerce</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <!-- Navegación -->
    <?php include 'components/nav.php'; ?>
    <!-- Hero Section -->
    <header class="bg-indigo-700 text-white">
        <div class="container mx-auto px-4 py-16 md:py-24 flex flex-col items-center text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Análisis Competitivo de Precios</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl">Optimiza tus estrategias de precios con nuestro servicio de web scraping. Mantente competitivo en el mercado con datos en tiempo real.</p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="servicios.php" class="bg-white text-indigo-700 hover:bg-indigo-100 px-6 py-3 rounded-lg font-semibold text-lg">Ver Todos los Servicios</a>
            </div>
    </header>

    <!-- Características -->
    <section class="py-12 md:py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Ventajas de Nuestro Servicio</h2>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-indigo-600 text-4xl mb-4">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Análisis en Tiempo Real</h3>
                    <p class="text-gray-600">Monitoreo constante de precios de la competencia para mantener tu negocio actualizado y competitivo.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-indigo-600 text-4xl mb-4">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Datos Precisos</h3>
                    <p class="text-gray-600">Información detallada y actualizada de precios en múltiples plataformas y mercados.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-indigo-600 text-4xl mb-4">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Automatización Inteligente</h3>
                    <p class="text-gray-600">Tecnología avanzada de scraping que ahorra tiempo y recursos en la recopilación de datos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Servicios Destacados -->
    <!-- Servicios Destacados -->
    <section class="py-12 md:py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Servicios Destacados</h2>

            <div class="grid md:grid-cols-3 gap-8">
                <?php
                // Incluir el archivo de conexión a la base de datos
                require_once 'config/ServicesDataBase.php';

                // Obtener servicios destacados
                $db = getDatabase();
                $conn = $db->getConnection();
                $servicios_destacados = $db->getServiciosDestacados(3);

                if (count($servicios_destacados) > 0) {
                    foreach ($servicios_destacados as $servicio) {
                ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($servicio['nombre']); ?></h3>
                                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars(substr($servicio['descripcion'], 0, 100)) . '...'; ?></p>
                                <div class="mb-4">
                                    <span class="text-sm text-gray-500">Desde</span>
                                    <div class="text-2xl font-bold text-indigo-600">$<?php echo number_format($servicio['precio_por_mes'], 2); ?>/mes</div>
                                </div>
                                <a href="servicio_detalle.php?id=<?php echo $servicio['id']; ?>" class="block text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">Ver Detalles</a>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    ?>
                    <div class="col-span-3 text-center">
                        <p class="text-gray-600">No hay servicios destacados disponibles en este momento.</p>
                    </div>
                <?php } ?>
            </div>

            <div class="text-center mt-12">
                <div class="text-center mt-12">
                    <a href="servicios.php" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">Ver Catálogo Completo</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section class="py-12 md:py-20">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Lo que dicen nuestros clientes</h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-200 rounded-full flex items-center justify-center text-indigo-600 font-bold mr-4">JD</div>
                        <div>
                            <h4 class="font-semibold">Juan Díaz</h4>
                            <div class="text-yellow-400">★★★★★</div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Excelente servicio, muy profesionales y siempre disponibles para resolver cualquier duda. Totalmente recomendado."</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-200 rounded-full flex items-center justify-center text-indigo-600 font-bold mr-4">ML</div>
                        <div>
                            <h4 class="font-semibold">María López</h4>
                            <div class="text-yellow-400">★★★★★</div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Los planes anuales ofrecen un gran valor. He renovado por segundo año consecutivo y no podría estar más satisfecha."</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-200 rounded-full flex items-center justify-center text-indigo-600 font-bold mr-4">RG</div>
                        <div>
                            <h4 class="font-semibold">Roberto González</h4>
                            <div class="text-yellow-400">★★★★☆</div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Buen servicio y soporte técnico rápido. La relación calidad-precio es excelente."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="bg-indigo-700 text-white py-12 md:py-20">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">¿Listo para comenzar?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Regístrate hoy y obtén un 10% de descuento en tu primer servicio.</p>
            <a href="registro.php" class="inline-block bg-white text-indigo-700 px-6 py-3 rounded-lg font-semibold text-lg hover:bg-indigo-100">Crear Cuenta Ahora</a>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'components/footer.php'; ?>

    <!-- Font Awesome para iconos -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>