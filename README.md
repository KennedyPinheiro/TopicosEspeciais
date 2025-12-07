# 📦 Projeto — IF Vendas

Ambiente completo para desenvolvimento utilizando **PHP + Laravel**, **MySQL**, **Node.js/Vite**, **Docker** e **Docker Compose**.  
Frontend em **React + Vite**, backend em **Laravel (PHP)** rodando em containers isolados.

---

# ✅ Pré-requisitos

Antes de rodar o projeto, instale:

### 🔹 Git
```bash
sudo apt install git -y
```

### 🔹 Docker
```bash
sudo apt install docker.io -y
```

### 🔹 Docker Compose (plugin)
```bash
sudo apt install docker-compose-plugin -y
```

### 🔹 Node.js (via NVM)
```bash
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
source ~/.nvm/nvm.sh
nvm install 18
```

### 🔹 PHP
```bash
sudo apt install php8.2 php8.2-mysql php8.2-curl php8.2-gd php8.2-mbstring php8.2-xml php8.2-zip -y
```
## 🚀 Como rodar o projeto

1️⃣ Clone o repositório
```bash
git clone https://github.com/KennedyPinheiro/TopicosEspeciais.git
cd TopicosEspeciais
```

### 🐳 Rodando com Docker (Recomendado)

2️⃣ Suba os containers
```bash
docker compose up -d --build
```

3️⃣ Acesse os serviços
Serviço	URL 

🌐 Frontend (Vite)	http://localhost:5173

🧩 Backend (PHP/Apache)	http://localhost:8080

🗄️ MySQL	host: localhost – porta: 3306


## 🔧 Como executar o backend (Laravel) dentro do Docker

👉 Entrar no container do backend
```bash
docker exec -it ivendas-backend bash
```

👉 Executar migrations
```bash
php artisan migrate
```

👉 Se precisar limpar cache do Laravel
```bash
php artisan optimize:clear
```

👉 Instalar dependências do Laravel (caso necessário)
```bash
composer install
```

👉 Rodar seeders
```bash
php artisan db:seed
```


Importante: O Laravel só enxerga o MySQL quando rodado dentro do container.

## 🗂️ Estrutura do projeto

### /frontend

### /backend

###  docker-compose.yml

###  docker/ 

### ├─ php/

### │   └─ Dockerfile

### ├─ node/

### │   └─ Dockerfile

###  └─ mysql/


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
Ver containers:

docker compose ps

Ver logs:

docker compose logs -f frontend

Derrubar tudo:

docker compose down

Derrubar e apagar volume do MySQL:

docker compose down -v



