# Directorio `resources/`

Este directorio está destinado a alojar los recursos de la aplicación que no han sido compilados.

## Subdirectorios comunes:
- **`views/`**: Plantillas Blade para el renderizado HTML de la aplicación en caso de ser necesario (Laravel sirve como API principal en este proyecto, pero este directorio sigue siendo clave si hay vistas que enviar, como plantillas de correo).
- **`css/` / `js/`**: Archivos de estilos (como TailwindCSS) y scripts de frontend en crudo antes de ser procesados (por ejemplo, con Vite) para producción.
- **`lang/`**: Archivos de traducción y localización, si la aplicación soporta múltiples idiomas en sus mensajes.
