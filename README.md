 README.md — Como rodar o projeto com Docker
🚀 Pré-requisitos

Antes de iniciar, você precisa ter instalado na máquina:

    Docker

    Docker Compose

🐳 Subindo o projeto com Docker
1. Clonar o repositório

git clonehttps://github.com/KennedyPinheiro/TopicosEspeciais.git
cd TopicosEspeciais

🧱 2. Build das imagens

Este comando constrói todas as imagens do projeto (frontend, backend e banco).

docker compose build --no-cache

▶️ 3. Iniciar os containers

Para subir tudo em modo detached (em segundo plano):

docker compose up -d

🔍 4. Acessar os serviços
🌐 Frontend (Vite + React)

http://localhost:5173

🖥️ Backend (PHP/Apache)

http://localhost:8080

🗄️ MySQL

    Host: localhost

    Porta: 3307

    Usuário: ivendas

    Senha: ivendas

    Banco: ivendas

🛑 Parar containers

docker compose down

Se quiser remover volumes (limpar banco de dados):

docker compose down -v


