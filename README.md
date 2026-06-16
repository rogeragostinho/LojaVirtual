# NexaStore — Loja Virtual

Plataforma de e-commerce desenvolvida em Laravel 11, com suporte a catálogo de produtos, carrinho de compras, wishlist, checkout e gestão de pedidos. Inclui área administrativa e autenticação de clientes.

---

## Pré-requisitos

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

---

## Como executar o projecto

### 1. Clonar o repositório

```bash
git clone https://github.com/rogeragostinho/LojaVirtual.git
cd LojaVirtual
```

### 2. Configurar o ambiente

```bash
cp .env.example .env
```

Abre o `.env` e ajusta as variáveis da base de dados:

```env
DB_HOST=db
DB_DATABASE=nexa_store
DB_USERNAME=nexa
DB_PASSWORD=nexa
```

### 3. Subir os containers

```bash
docker compose up -d --build
```

### 4. Instalar as dependências PHP

```bash
docker compose exec app composer install
```

### 5. Gerar a chave da aplicação

```bash
docker compose exec app php artisan key:generate
```

### 6. Executar as migrations

```bash
docker compose exec app php artisan migrate
```

### 7. Corrigir permissões

```bash
docker compose exec app bash -c "chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && chmod -R 775 /var/www/storage /var/www/bootstrap/cache"
```

### 8. Criar link simbólico para ficheiros públicos

```bash
docker compose exec app php artisan storage:link
```

### 9. Aceder à aplicação

Abre o browser em: [http://localhost:8000](http://localhost:8000)

---

## Funcionalidades

| Módulo | Descrição |
|---|---|
| Catálogo | Listagem de produtos por categoria e pesquisa |
| Produto | Página de detalhe por slug |
| Carrinho | Adicionar, remover e actualizar quantidades |
| Wishlist | Guardar produtos favoritos (requer login) |
| Checkout | Processar encomendas (requer login) |
| Pedidos | Histórico e detalhe de pedidos do cliente |
| Perfil | Editar dados pessoais e password |
| Admin | Área administrativa separada |
| Autenticação | Registo, login e logout via Laravel Breeze |

---

## Stack tecnológica

- **Backend:** Laravel 11 / PHP 8.2
- **Frontend:** Vite / Tailwind CSS / Laravel Breeze
- **Base de dados:** MySQL 8.0
- **Servidor web:** Nginx
- **Ambiente:** Docker

---

## Comandos úteis

```bash
# Parar os containers
docker compose down

# Ver logs da aplicação
docker compose logs app

# Aceder à base de dados
docker compose exec db mysql -u nexa -p

# Recompilar assets frontend
docker compose up -d --build node
```

---

## Estrutura Docker

```
├── Dockerfile              # Imagem personalizada PHP 8.2
├── docker-compose.yml      # Orquestração dos containers
└── docker/
    └── nginx.conf          # Configuração do servidor web
```
