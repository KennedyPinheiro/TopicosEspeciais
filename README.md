📦 Projeto — Nome do Projeto

Um ambiente completo para desenvolvimento utilizando PHP, MySQL, Node.js, NVM e Docker Compose, com frontend em Node/Vite e backend em PHP/Apache.
✅ Pré-requisitos

Antes de rodar o projeto, instale:
🔹 Git

sudo apt install git -y

🔹 Docker

sudo apt install docker.io -y

🔹 Docker Compose (plugin)

sudo apt install docker-compose-plugin -y

🔹 Node.js (via NVM)

Recomendado apenas se você quiser rodar o frontend fora do Docker.

Instalar NVM:

curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash

Recarregar shell:

source ~/.nvm/nvm.sh

Instalar versão recomendada:

nvm install 18

    O Docker já fornece Node dentro do container, então instalar NVM é opcional.

🔹 PHP

Também opcional, pois o backend roda dentro do Docker.
🚀 Como rodar o projeto
1️⃣ Clone o repositório

git clone https://github.com/SEU-USUARIO/SEU-REPO.git
cd SEU-REPO

🐳 Rodando com Docker (Recomendado)
2️⃣ Suba os containers

docker compose up -d --build

3️⃣ Acesse os serviços
Serviço	URL
🌐 Frontend (Vite)	http://localhost:5173
🧩 Backend (PHP/Apache)	http://localhost:8080
🗄️ MySQL	host: localhost – porta: 3306
🗂️ Estrutura do projeto

/frontend
/backend
docker-compose.yml
docker/
 ├─ php/
 │   └─ Dockerfile
 ├─ node/
 │   └─ Dockerfile
 └─ mysql/
     └─ data/   (IGNORADA pelo Git)

📄 .gitignore

Certifique-se de que existe um .gitignore na raiz contendo:

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

🛠️ Comandos úteis
Ver containers:

docker compose ps

Ver logs:

docker compose logs -f frontend

Derrubar tudo:

docker compose down

Derrubar e apagar volume do MySQL:

docker compose down -v