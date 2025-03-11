<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestros Servicios de Web Scraping</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">
    <!-- Navegación (igual que en index) -->
    <?php include 'components/nav.php'; ?>

    <!-- Header de Servicios -->
    <header class="bg-indigo-700 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4">Nuestros Servicios de Web Scraping</h1>
            <p class="text-xl">Soluciones completas para el análisis de precios y competencia</p>
        </div>
    </header>

    <!-- Filtro por Categorías -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-wrap gap-4 mb-8">
            <?php
            require_once 'config/ServicesDataBase.php';
            $db = getDatabase();
            $categorias = $db->getCategorias();
            ?>
            <button class="categoria-btn bg-indigo-600 text-white px-4 py-2 rounded-lg" data-categoria="todos">
                Todos los servicios
            </button>
            <?php foreach ($categorias as $categoria): ?>
                <button class="categoria-btn bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg hover:bg-indigo-200"
                    data-categoria="<?php echo htmlspecialchars($categoria); ?>">
                    <?php echo htmlspecialchars($categoria); ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Grid de Servicios -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $servicios = $db->getServiciosActivos();
            foreach ($servicios as $servicio):
            ?>
                <div class="servicio-card bg-white rounded-lg shadow-md overflow-hidden"
                    data-categoria="<?php echo htmlspecialchars($servicio['categoria']); ?>">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">
                            <?php echo htmlspecialchars($servicio['nombre']); ?>
                        </h3>
                        <p class="text-gray-600 mb-4">
                            <?php echo htmlspecialchars($servicio['descripcion']); ?>
                        </p>

                        <!-- Precios -->
                        <div class="space-y-2 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Mensual:</span>
                                <span class="font-semibold">$<?php echo number_format($servicio['precio_por_mes'], 2); ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Trimestral:</span>
                                <span class="font-semibold">$<?php echo number_format($servicio['precio_por_trimestre'], 2); ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Anual:</span>
                                <span class="font-semibold">$<?php echo number_format($servicio['precio_por_anio'], 2); ?></span>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="space-y-2">
                            <?php if (isset($_SESSION['usuario_id'])): ?>
                                <?php
                                $carritoDB = new CarritoDataBase();
                                $servicioActivo = $carritoDB->verificarServicioActivo($_SESSION['usuario_id'], $servicio['id']);

                                if ($servicioActivo):
                                    if ($servicioActivo['estado'] === 'comprado'):
                                ?>
                                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-lg">
                                            <p class="text-center">Ya tienes este servicio</p>
                                            <p class="text-sm text-center">
                                                Expira: <?php echo date('d/m/Y', strtotime($servicioActivo['fecha_expiracion'])); ?>
                                            </p>
                                        </div>
                                    <?php else: ?>
                                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-2 rounded-lg text-center">
                                            Este servicio ya está en tu carrito
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <form action="agregar_carrito.php" method="POST" class="space-y-2">
                                        <input type="hidden" name="servicio_id" value="<?php echo $servicio['id']; ?>">
                                        <select name="tipo_plan" class="w-full p-2 border rounded-lg mb-2">
                                            <option value="mensual">Mensual - $<?php echo number_format($servicio['precio_por_mes'], 2); ?></option>
                                            <option value="trimestral">Trimestral - $<?php echo number_format($servicio['precio_por_trimestre'], 2); ?></option>
                                            <option value="anual">Anual - $<?php echo number_format($servicio['precio_por_anio'], 2); ?></option>
                                        </select>
                                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                                            Agregar al Carrito
                                        </button>
                                    </form>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="login.php" class="block text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">
                                    Iniciar sesión para comprar
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Sección de Comparativa de Planes -->
    <section class="bg-gray-100 py-12">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">Compara Nuestros Planes</h2>
            <!-- Aquí puedes agregar una tabla comparativa de planes -->
        </div>
    </section>

    <!-- Footer (igual que en index) -->
    <?php include 'components/footer.php'; ?>

    <!-- JavaScript para el filtrado -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botones = document.querySelectorAll('.categoria-btn');
            const servicios = document.querySelectorAll('.servicio-card');

            botones.forEach(boton => {
                boton.addEventListener('click', () => {
                    // Actualizar estados de los botones
                    botones.forEach(b => b.classList.remove('bg-indigo-600', 'text-white'));
                    botones.forEach(b => b.classList.add('bg-indigo-100', 'text-indigo-700'));
                    boton.classList.remove('bg-indigo-100', 'text-indigo-700');
                    boton.classList.add('bg-indigo-600', 'text-white');

                    const categoria = boton.dataset.categoria;

                    servicios.forEach(servicio => {
                        if (categoria === 'todos' || servicio.dataset.categoria === categoria) {
                            servicio.style.display = 'block';
                        } else {
                            servicio.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>