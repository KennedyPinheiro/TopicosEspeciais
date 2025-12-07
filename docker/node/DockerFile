FROM node:18

WORKDIR /app

# Copia apenas package.json para instalar dependências
COPY package*.json ./

# Instalar TODAS as dependências (incluindo devDependencies)
RUN npm install

# Agora sim copie o restante do código
COPY . .

EXPOSE 5173

# Força o Vite a rodar no host 0.0.0.0 (necessário no Docker)
CMD ["npm", "run", "dev", "--", "--host"]
