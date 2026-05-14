#!/bin/bash

# 1. Limpiar rastro del intento anterior
sudo rm -f /etc/apt/sources.list.d/docker.list
sudo apt remove apache2
sudo apt autoremove

echo "Actualizando índices de Debian..."
sudo apt-get update

# 2. Instalar dependencias
sudo apt-get install -y iptables
sudo apt-get install -y ca-certificates curl gnupg

# 3. Llave GPG oficial de Docker
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/debian/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
sudo chmod a+r /etc/apt/keyrings/docker.gpg

# 4. Configurar repositorio (Usando 'bookworm' como base estable si trixie falla)
# Docker a veces no tiene carpeta 'trixie' todavía, así que usamos la de Debian estable
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/debian \
  bookworm stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# 5. Instalar
echo "Instalando Docker Engine..."
sudo apt-get update
sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
echo "Instalando PHP..."
sudo apt-get install -y php # Añadida instalación de PHP

# 6. Verificación real
if command -v docker &> /dev/null
then
    echo "¡Docker instalado con éxito!"
    docker --version
else
    echo "Hubo un error en la instalación."
fi

sudo usermod -aG docker $USER

sudo systemctl start docker
sudo systemctl enable docker

echo "Reinicia el sistema y ejecuta setup_arena_part02.sh"