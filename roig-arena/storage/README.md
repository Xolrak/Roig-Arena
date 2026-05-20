# Directorio `storage/`

Este directorio es utilizado para guardar todo aquel archivo o dato generado por la aplicación en tiempo de ejecución. **Es imprescindible que la aplicación tenga permisos de escritura sobre este directorio.**

## Subdirectorios principales:
- **`app/`**: Se usa para guardar los archivos y documentos subidos a la aplicación. El directorio `storage/app/public` en particular, se utiliza para guardar archivos públicos que serán expuestos usando un enlace simbólico (`public/storage`).
- **`framework/`**: Usado por el propio Laravel para almacenar archivos de funcionamiento interno, como las vistas compiladas de Blade, cachés basadas en archivos y las sesiones del sistema si no se manejan en base de datos.
- **`logs/`**: Contiene el archivo de registro `laravel.log`. Todo error, warning o evento informativo queda documentado en los archivos de este directorio, lo que lo hace vital para depurar errores.
