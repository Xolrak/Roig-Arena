# Directorio `bootstrap/`

Este directorio contiene los archivos que inicializan (hacen el "bootstrap") del framework Laravel.

## Archivos clave:
- **`app.php`**: El script principal que inicializa la aplicación, el contenedor de servicios de Laravel y registra los middlewares y el enrutamiento base.
- **`cache/`**: Este directorio aloja los archivos generados automáticamente para optimizar el rendimiento de la aplicación, como la caché de las rutas, la caché de los servicios y la caché de las vistas. Estos archivos no deben ser modificados manualmente.
