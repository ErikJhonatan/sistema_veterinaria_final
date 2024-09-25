# Sistema de gestión veterinaria

Aplicación Laravel para gestión veterinaria: clientes, mascotas, inventario, ventas, caja y recursos humanos.

## Alcance del repositorio

El código contiene rutas, controladores y vistas para clientes y mascotas, historial clínico, servicios, productos y proveedores. También incluye módulos de ventas, comprobantes, almacenes, stock, caja y registros contables, además de pantallas de recursos humanos.

## Tecnologías y estructura

- PHP 8.2 y Laravel 11, según `composer.json`.
- Blade y recursos frontend preparados con Vite.
- `app/`: controladores, modelos, servicios y comandos.
- `routes/`: rutas de la aplicación y autenticación.
- `resources/`: vistas y recursos de la interfaz.
- `database/`: migraciones y material de inicialización.

## Preparación local

Instala las dependencias con `composer install` y `npm install`. Crea tu archivo `.env` a partir de `.env.example` y configura una base de datos local antes de ejecutar migraciones. Los scripts de desarrollo disponibles son `php artisan serve` y `npm run dev`.

El README anterior indicaba una carga de `database/banco/data.sql` y el comando `php artisan app:variaciones-historia-clinica`. Revisa su contenido y propósito antes de usarlos en una base de datos. No se han ejecutado durante esta revisión.

## Estado

Proyecto académico con varios módulos de negocio. La descripción se basa en inspección de código y no acredita un despliegue ni pruebas aprobadas. La versión `sistema-veterinaria` conserva diferencias y un archivo SQL propio; no es una copia idéntica.
