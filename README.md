# IF Vendas — Ambiente Completo com Docker

Ambiente de desenvolvimento utilizando:

    Laravel 10 (PHP 8.2 + Apache)

    MySQL 8

    React + Vite (Node 22)

    Docker + Docker Compose

O projeto roda inteiramente em containers — sem precisar instalar PHP ou Node na sua máquina.
---

#  Pré-requisitos

Antes de rodar o projeto, instale:

### 🔹 Git
```bash
sudo apt install git -y
```

### 🔹 Docker
```bash
sudo apt install docker.io -y
```

### 🔹 Docker Compose plugin
```bash
sudo apt install docker-compose-plugin -y
```

## 🚀 Como rodar o projeto

1️⃣ Clone o repositório
```bash
git clone https://github.com/KennedyPinheiro/TopicosEspeciais.git
cd TopicosEspeciais
```

###  Rodando com Docker (Recomendado)

2️⃣ Suba os containers
```bash
docker compose up -d --build
```


## Configuração do Backend

Entrar no container do backend
```bash
docker exec -it ivendas-backend bash
```
1. Criar arquivo de ambiente
```bash
cp .env.example .env
```

2. Instalar dependências
```bash
composer install
```

3. Gerar APP_KEY
```bash
php artisan key:generate
```

4. Ajustar permissões
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

5. Executar migrations
```bash
php artisan migrate
```

6. Executar seeders
```bash
php artisan db:seed
```

7. Limpar caches do Laravel
```bash
php artisan optimize:clear
```
Importante: O Laravel só enxerga o MySQL quando rodado dentro do container.

## Frontend (React + Vite)

O container já roda automaticamente o Vite:
➡ http://localhost:5173

```bash
docker exec -it ivendas-frontend bash
```

Rodar manualmente
```bash
npm run dev -- --host
```


## 🗂️ Estrutura do projeto
```bash
### TopicosEspeciais/
#### ├── backend/         
#### ├── frontend/        
#### ├── docker/           
#### │   ├── php/
#### │   │   ├── Dockerfile
#### │   │   └── vhost.conf
#### │   └── node/
#### │       └── Dockerfile
#### └── README.md
```

## .gitignore recomendado
```bash
# Logs
*.log
npm-debug.log*
yarn-debug.log*
yarn-error.log*

# Node
node_modules/
frontend/node_modules/

# PHP vendor
backend/vendor/

# Docker MySQL
docker/mysql/data/

# Environment
.env
.env.local

```

## 🛠️ Comandos úteis

### Ver containers:

docker compose ps

### Ver logs:

docker compose logs -f frontend

docker compose logs -f backend

### Derrubar tudo:

docker compose down

### Derrubar e apagar volume do MySQL:

docker compose down -v



