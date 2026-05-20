# Directorio `database/`

Este directorio contiene todo lo relacionado con la estructura y los datos iniciales de la base de datos MySQL de la aplicación.

## Estructura interna:
- **`migrations/`**: Clases que describen los cambios (creación o alteración de tablas) en la base de datos. Sirven como control de versiones para el esquema.
- **`factories/`**: Plantillas para generar datos aleatorios (falsos pero estructurados). Se utilizan sobre todo durante la ejecución de tests para simular datos masivos.
- **`seeders/`**: Scripts encargados de poblar o inicializar la base de datos con datos reales o predefinidos. Por ejemplo, la creación de los sectores del recinto y la generación de los asientos (a través de `SectorSeeder` y `AsientoSeeder`).
