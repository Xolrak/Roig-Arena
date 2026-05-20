# Directorio `tests/`

Este directorio contiene las suites de pruebas automatizadas que verifican y aseguran la calidad y funcionamiento del código desarrollado. 

## Estructura de pruebas:
- **`Unit/`**: Contiene pruebas unitarias (`Unit Tests`). Estas pruebas están orientadas a aislar y validar el comportamiento de pequeñas partes del código en entornos muy acotados. Por ejemplo, testear las funciones específicas de los servicios (`ReservaServiceTest`, `CompraServiceTest`).
- **`Feature/`**: Contiene pruebas funcionales y de integración. Estas pruebas testean gran parte de la aplicación simulando peticiones HTTP completas a las rutas y verificando sus respuestas e integraciones con la base de datos (por ejemplo, `ReservaTest` o `EventoTest`).

## Ejecución
Para ejecutar el banco de pruebas completo con la infraestructura provista en Sail (Docker):
```bash
sail artisan test
```
