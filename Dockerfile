# Usa a imagem oficial do PHP 8.2 FPM como base
FROM php:8.4-fpm

# Define o diretório de trabalho dentro do container
WORKDIR /var/www

# Instala as dependências do sistema e ferramentas utilitárias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev

# Limpa o cache do gerenciador de pacotes para reduzir o tamanho da imagem
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala as extensões PHP necessárias para o Laravel 11 e MySQL
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Copia a versão mais recente do Composer diretamente da imagem oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cria um utilizador de sistema para rodar os comandos do Composer e Artisan com segurança
RUN useradd -G www-data,root -u 1000 -d /home/dev dev
RUN mkdir -p /home/dev/.composer && chown -R dev:dev /home/dev

# Define o utilizador criado como o utilizador padrão do container
USER dev

# Expõe a porta 9000 para a comunicação com o servidor web (Nginx/Apache)
EXPOSE 9000

# Comando padrão para iniciar o PHP-FPM
CMD ["php-fpm"]