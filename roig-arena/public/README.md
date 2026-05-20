# Directorio `public/`

Esta es la raíz del servidor web (el document root) y contiene todos los archivos estáticos a los que el navegador puede acceder directamente, como imágenes, JavaScript y CSS precompilado.

## Archivos importantes:
- **`index.php`**: Es el punto de entrada para todas las solicitudes HTTP que llegan a la aplicación. Su única tarea es inicializar el entorno de Laravel, ejecutar la aplicación y despachar la petición para que sea procesada por el framework.
- **`.htaccess`**: Archivo de configuración para servidores web Apache, utilizado fundamentalmente para redirigir todas las solicitudes web al `index.php`.
