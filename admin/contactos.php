<?php
require_once '../config/ContactoDataBase.php';
// Aquí deberías agregar autenticación de administrador

$db = getContactoDB();
$estado = $_GET['estado'] ?? null;
$pagina = $_GET['pagina'] ?? 1;
$por_pagina = 10;
$offset = ($pagina - 1) * $por_pagina;

try {
    $contactos = $db->obtenerContactos($estado, $por_pagina, $offset);
    $total_contactos = $db->contarContactos($estado);
    $total_paginas = ceil($total_contactos / $por_pagina);
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Contactos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Administrar Mensajes de Contacto</h1>
        
        <!-- Filtros -->
        <div class="mb-6">
            <select id="filtroEstado" onchange="filtrarPorEstado(this.value)" class="border rounded px-3 py-2">
                <option value="">Todos los estados</option>
                <option value="pendiente">Pendientes</option>
                <option value="en_proceso">En Proceso</option>
                <option value="respondido">Respondidos</option>
                <option value="archivado">Archivados</option>
            </select>
        </div>
        
        <!-- Tabla de contactos -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($contactos as $contacto): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo date('d/m/Y H:i', strtotime($contacto['fecha_creacion'])); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php echo htmlspecialchars($contacto['nombre']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php echo htmlspecialchars($contacto['email']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php echo htmlspecialchars($contacto['asunto']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                       <?php echo getEstadoClase($contacto['estado']); ?>">
                                <?php echo ucfirst($contacto['estado']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="ver_contacto.php?id=<?php echo $contacto['id']; ?>" 
                               class="text-indigo-600 hover:text-indigo-900">Ver</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function filtrarPorEstado(estado) {
        window.location.href = 'contactos.php' + (estado ? '?estado=' + estado : '');
    }
    </script>
</body>
</html>

<?php
function getEstadoClase($estado) {
    switch ($estado) {
        case 'pendiente':
            return 'bg-yellow-100 text-yellow-800';
        case 'en_proceso':
            return 'bg-blue-100 text-blue-800';
        case 'respondido':
            return 'bg-green-100 text-green-800';
        case 'archivado':
            return 'bg-gray-100 text-gray-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}
?>