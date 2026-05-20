# Directorio `app/`

Este directorio contiene la lógica central y el código principal de la aplicación. 
En Laravel, la mayor parte de las clases de la aplicación se encuentran aquí.

## Subdirectorios principales:
- **`Console/`**: Comandos de consola (Artisan) personalizados.
- **`Http/`**: Manejo de peticiones HTTP. Contiene los **Controladores** (`Controllers/`), **Middlewares** (`Middleware/`) y recursos de la API (`Resources/`).
- **`Models/`**: Modelos de Eloquent, que representan las tablas de la base de datos y sus relaciones (ej. Evento, Asiento, Reserva).
- **`Providers/`**: Proveedores de servicios (Service Providers) que se encargan de registrar y configurar los distintos servicios de la aplicación en el contenedor de Laravel.
- **`Services/`**: (Directorio personalizado). Contiene la lógica de negocio compleja que se desacopla de los controladores, como el `ReservaService` o `CompraService`.
