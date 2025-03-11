<?php
require_once 'config/ServicesDataBase.php';
$db = getDatabase();
$categorias = $db->getCategorias();
?>

<footer class="bg-gray-800 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-4 gap-8">
            <!-- Columna 1 - Información de la empresa -->
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <img src="assets/images/logo.png" alt="Logo" class="h-8 w-8">
                    <h3 class="text-xl font-semibold">PriceTracker</h3>
                </div>
                <p class="text-gray-400">Soluciones avanzadas de web scraping y análisis de precios para optimizar tu estrategia competitiva.</p>
                <div class="mt-4 flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
            </div>

            <!-- Columna 2 - Servicios -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Servicios</h4>
                <ul class="space-y-2 text-gray-400">
                    <?php foreach ($categorias as $categoria): ?>
                    <li>
                        <a href="servicios.php?categoria=<?php echo urlencode($categoria); ?>" 
                           class="hover:text-white transition-colors">
                            <?php echo htmlspecialchars($categoria); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Columna 3 - Enlaces Rápidos -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Enlaces Rápidos</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="index.php" class="hover:text-white transition-colors">Inicio</a></li>
                    <li><a href="servicios.php" class="hover:text-white transition-colors">Servicios</a></li>
                    <li><a href="contacto.php" class="hover:text-white transition-colors">Contacto</a></li>
                </ul>
            </div>

            <!-- Columna 4 - Contacto -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Contacto</h4>
                <ul class="space-y-2 text-gray-400">
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-envelope"></i>
                        <span>info@pricetracker.com</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-phone"></i>
                        <span>+52 (55) 1234-5678</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Ciudad de México, México</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Barra inferior -->
        <div class="border-t border-gray-700 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    &copy; <?php echo date('Y'); ?> PriceTracker. Todos los derechos reservados.
                </p>
                <div class="flex space-x-4 mt-4 md:mt-0 text-sm text-gray-400">
                    <a href="privacidad.php" class="hover:text-white">Política de Privacidad</a>
                    <a href="terminos.php" class="hover:text-white">Términos de Servicio</a>
                    <a href="cookies.php" class="hover:text-white">Política de Cookies</a>
                </div>
            </div>
        </div>
    </div>
</footer>

