CREATE TABLE servicios (
id INT AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(100) NOT NULL,
precio_por_mes DECIMAL(10, 2),
precio_por_anio DECIMAL(10, 2),
precio_por_trimestre DECIMAL(10, 2),
descripcion TEXT,
categoria VARCHAR(50),
fecha_disponibilidad_inicio DATE,
fecha_disponibilidad_fin DATE,
activo BOOLEAN DEFAULT TRUE,
fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO servicios (
nombre,
precio_por_mes,
precio_por_anio,
precio_por_trimestre,
descripcion,
categoria,
fecha_disponibilidad_inicio,
fecha_disponibilidad_fin,
activo
) VALUES
(
'Scraping Básico',
99.99,
999.99,
279.99,
'Monitoreo de hasta 100 productos, actualización diaria de precios, reportes semanales en formato CSV y alertas básicas
de cambios de precio.',
'Scraping Básico',
NULL,
NULL,
1
),
(
'Scraping Pro',
199.99,
1999.99,
549.99,
'Monitoreo de hasta 500 productos, actualización en tiempo real, reportes personalizados, panel de control avanzado y
API REST para integración.',
'Scraping Avanzado',
NULL,
NULL,
1
),
(
'Scraping Enterprise',
499.99,
4999.99,
1399.99,
'Monitoreo ilimitado de productos, múltiples marketplaces, API dedicada, soporte 24/7, análisis predictivo y estrategias
de pricing.',
'Scraping Enterprise',
NULL,
NULL,
1
),
(
'Análisis Competitivo Básico',
149.99,
1499.99,
419.99,
'Análisis mensual de competidores directos, reportes de posicionamiento de precios y recomendaciones básicas de
pricing.',
'Análisis',
NULL,
NULL,
1
),
(
'Análisis Competitivo Avanzado',
299.99,
2999.99,
839.99,
'Análisis semanal detallado, seguimiento de hasta 10 competidores, estrategias de pricing y alertas personalizadas.',
'Análisis',
NULL,
NULL,
1
),
(
'Dashboard Personalizado',
79.99,
799.99,
219.99,
'Panel de control personalizado para visualización de datos, gráficos interactivos y exportación de reportes.',
'Herramientas',
NULL,
NULL,
1
),
(
'API Integration',
149.99,
1499.99,
419.99,
'Acceso a API REST para integración con sistemas propios, documentación completa y soporte técnico.',
'Integración',
NULL,
NULL,
1
),
(
'Market Intelligence',
399.99,
3999.99,
1119.99,
'Análisis completo de mercado, tendencias de precios, predicciones y recomendaciones estratégicas.',
'Inteligencia de Mercado',
NULL,
NULL,
1
),
(
'Alertas Premium',
59.99,
599.99,
169.99,
'Sistema avanzado de alertas personalizables por email, SMS y webhook para cambios de precios y stock.',
'Alertas',
NULL,
NULL,
1
),
(
'Consultoría de Pricing',
299.99,
2999.99,
839.99,
'Asesoría personalizada en estrategias de pricing, análisis de márgenes y optimización de precios.',
'Consultoría',
NULL,
NULL,
1
);
