#!/bin/bash

# Configuración de colores para mejor legibilidad
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${BLUE}>>> Iniciando proceso de reinicio del entorno Arena2 (DB remota en AWS)...${NC}\n"

# 1. Levantar base de datos en AWS
echo -e "${YELLOW}[1/5] Levantando base de datos en AWS...${NC}"

# (!!) IMPORTANTE: CAMBIA LA RUTA Y LA IP (!!) ###########################################################
#
ssh -i ./.ssh/arena-db-key.pem ubuntu@98.89.101.197 "docker compose -f compose-database-server.yaml up -d"
#
##########################################################################################################
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✔ Base de datos en AWS iniciada.${NC}"
    echo -e "${YELLOW}Esperando a que MySQL esté listo...${NC}"
    echo -n "Esperando"
    for i in {1..20}; do
        echo -n "."
        sleep 1
    done
    echo ""
    echo -e "${GREEN}✔ MySQL listo.${NC}\n"
else
    echo "Error al iniciar base de datos en AWS"; exit 1
fi

# 2. Acceder al directorio del proyecto
cd arena2 || { echo "Error: No se pudo encontrar la carpeta 'arena2'"; exit 1; }

# 3. Detener contenedores locales (sin -v porque la DB está en AWS)
echo -e "${YELLOW}[2/5] Deteniendo contenedores locales...${NC}"
# 3. Detener contenedores locales (sin -v porque la DB está en AWS)
echo -e "${YELLOW}[2/5] Deteniendo contenedores locales...${NC}"
./vendor/bin/sail down
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✔ Contenedores detenidos correctamente.${NC}\n"
else
    echo "Error al detener contenedores"; exit 1
fi

# 4. Iniciar contenedores en segundo plano
echo -e "${YELLOW}[3/5] Levantando servicios en modo detach...${NC}"
./vendor/bin/sail up -d
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✔ Servicios iniciados.${NC}\n"
else
    echo "Error al iniciar Sail"; exit 1
fi

# 5. Ejecutar migraciones y seeders en la base de datos remota
echo -e "${YELLOW}[4/5] Ejecutando migraciones y poblando base de datos remota...${NC}"
./vendor/bin/sail artisan migrate:fresh --seed
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✔ Base de datos remota lista y poblada.${NC}\n"
else
    echo "Error en las migraciones"; exit 1
fi

# 6. Ejecutar tests
echo -e "${YELLOW}[5/5] Ejecutando batería de tests...${NC}"
./vendor/bin/sail artisan test
if [ $? -eq 0 ]; then
    echo -e "\n${GREEN}🚀 TODO CORRECTO: Entorno reiniciado, poblado y testeado con éxito.${NC}"
else
    echo -e "\n${YELLOW}⚠ Los servicios están arriba pero algunos tests han fallado.${NC}"
    exit 1
fi
