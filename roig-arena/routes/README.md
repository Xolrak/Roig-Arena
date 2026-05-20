# Directorio `routes/`

Aquí se definen y registran todas las rutas (puntos de entrada o endpoints) de la aplicación, mapeando peticiones HTTP (o comandos de consola) a Controladores específicos.

## Archivos de rutas:
- **`api.php`**: Contiene las rutas para el consumo de la API REST. Todas las rutas definidas en este archivo utilizan el middleware `api` y están preparadas para trabajar devolviendo JSON (stateless). En este proyecto centraliza el ecosistema del Arena (Eventos, Reservas, Compras, etc).
- **`web.php`**: Rutas web clásicas que utilizan estado, manejo de sesión y cookies (CSRF). 
- **`console.php`**: Aquí se pueden definir comandos de consola mediante el uso de "closures" en lugar de tener que crear una clase para cada comando en el directorio de `app/Console`.
