<?php
function isCurrentPage($page)
{
    $current_page = basename($_SERVER['PHP_SELF']);
    return $current_page === $page ? 'text-indigo-200 border-b-2 border-indigo-200' : 'hover:text-indigo-200';
}

session_start();
$isLoggedIn = isset($_SESSION['usuario_id']);
$isAdmin = $isLoggedIn && $_SESSION['usuario_tipo'] === 'admin';

// Obtener cantidad de items en el carrito
// En nav.php
$cantidadCarrito = 0;
if ($isLoggedIn && !$isAdmin) {
    require_once __DIR__ . '/../config/CarritoDataBase.php';
    try {
        $carritoDB = getCarritoDB();
        if ($carritoDB) {
            $items = $carritoDB->obtenerCarrito($_SESSION['usuario_id']);
            $cantidadCarrito = count($items);
        }
    } catch (Exception $e) {
        error_log("Error al obtener carrito: " . $e->getMessage());
    }
}
?>

<nav class="bg-indigo-600 text-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <!-- Logo y Nombre -->
            <div class="flex items-center space-x-4">
                <a href="index.php" class="flex items-center space-x-2">
                    <img src="assets/images/logo.png" alt="Logo" class="h-8 w-8">
                    <span class="text-2xl font-bold">PriceTracker</span>
                </a>
            </div>

            <!-- Menú principal - Desktop -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="<?php echo isCurrentPage('index.php'); ?>">Inicio</a>
                <a href="servicios.php" class="<?php echo isCurrentPage('servicios.php'); ?>">Servicios</a>

                <?php if ($isLoggedIn && !$isAdmin): ?>
                    <a href="carrito.php" class="relative group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <?php if ($cantidadCarrito > 0): ?>
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                <?php echo $cantidadCarrito; ?>
                            </span>
                        <?php endif; ?>
                        <div class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl py-2 hidden group-hover:block">
                            <div class="px-4 py-2 text-gray-800">
                                <?php if ($cantidadCarrito > 0): ?>
                                    <p><?php echo $cantidadCarrito; ?> servicio(s) en el carrito</p>
                                <?php else: ?>
                                    <p>Carrito vacío</p>
                                <?php endif; ?>
                            </div>
                            <a href="carrito.php" class="block px-4 py-2 text-indigo-600 hover:bg-indigo-100">
                                Ver carrito completo
                            </a>
                        </div>
                    </a>
                <?php endif; ?>

                <?php if ($isAdmin): ?>
                    <a href="admin/index.php" class="<?php echo isCurrentPage('dashboard.php'); ?>">Dashboard</a>
                <?php endif; ?>
                <a href="contacto.php" class="<?php echo isCurrentPage('contacto.php'); ?>">Contacto</a>
            </div>

            <!-- Botones de Acción -->
            <!-- Botones de Acción -->
            <div class="hidden md:flex items-center space-x-4">
                <?php if ($isLoggedIn): ?>
                    <div class="relative">
                        <button id="profile-button" class="flex items-center space-x-2 bg-indigo-700 px-4 py-2 rounded-lg hover:bg-indigo-800">
                            <span class="text-white font-medium"><?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></span>
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="profile-dropdown" class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl py-2 hidden">
                            <?php if (!$isAdmin): ?>
                                <a href="mis-compras.php" class="flex items-center px-4 py-2 text-gray-800 hover:bg-indigo-100">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18M9 9h6m-6 4h6m-6 4h6" />
                                    </svg>
                                    Mis Compras
                                </a>
                                <a href="perfil.php" class="flex items-center px-4 py-2 text-gray-800 hover:bg-indigo-100">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A4 4 0 0112 15h0a4 4 0 016.879 2.804M15 11a4 4 0 10-8 0m8 0a4 4 0 11-8 0" />
                                    </svg>
                                    Mi Perfil
                                </a>
                            <?php endif; ?>
                            <a href="logout.php" class="flex items-center px-4 py-2 text-gray-800 hover:bg-indigo-100">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                                </svg>
                                Cerrar Sesión
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="hover:text-indigo-200">Iniciar Sesión</a>
                    <a href="signup.php" class="bg-white text-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-100">Registrarse</a>
                <?php endif; ?>
            </div>

            <!-- Menú móvil - Botón -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-white hover:text-indigo-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Menú móvil - Contenido -->
        <div id="mobile-menu" class="hidden md:hidden mt-4">
            <div class="flex flex-col space-y-4">
                <a href="index.php" class="hover:text-indigo-200">Inicio</a>
                <a href="servicios.php" class="hover:text-indigo-200">Servicios</a>
                <?php if ($isLoggedIn && !$isAdmin): ?>
                    <a href="carrito.php" class="hover:text-indigo-200 flex items-center justify-between">
                        <span>Carrito</span>
                        <?php if ($cantidadCarrito > 0): ?>
                            <span class="bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                <?php echo $cantidadCarrito; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <a href="mis-compras.php" class="hover:text-indigo-200">Mis Compras</a>
                    <a href="perfil.php" class="hover:text-indigo-200">Mi Perfil</a>
                <?php endif; ?>
                <?php if ($isAdmin): ?>
                    <a href="admin/index.php" class="hover:text-indigo-200">Dashboard</a>
                <?php endif; ?>
                <a href="contacto.php" class="hover:text-indigo-200">Contacto</a>

                <div class="border-t border-indigo-500 pt-4">
                    <?php if ($isLoggedIn): ?>
                        <div class="text-sm mb-2">
                            Conectado como: <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>
                        </div>
                        <a href="logout.php" class="block bg-white text-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-100 text-center">
                            Cerrar Sesión
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="block hover:text-indigo-200 mb-2">Iniciar Sesión</a>
                        <a href="signup.php" class="block bg-white text-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-100 text-center">
                            Registrarse
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    // Menú móvil
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    // Menú de perfil
    document.addEventListener('DOMContentLoaded', function() {
        const profileButton = document.getElementById('profile-button');
        const profileDropdown = document.getElementById('profile-dropdown');

        if (profileButton && profileDropdown) {
            // Toggle del menú al hacer clic en el botón
            profileButton.addEventListener('click', function(e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('hidden');
            });

            // Cerrar el menú al hacer clic fuera
            document.addEventListener('click', function(e) {
                if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });

            // Prevenir que el menú se cierre al hacer clic dentro de él
            profileDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
</script>