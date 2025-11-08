# Requisitos
- PHP ^8.2
- Composer
- Laravel ^12.0 
- Docker
---
## Instalação

### Configure o ambiente
```bash
cp .env.example .env
```

### Inicie os containers Docker
```bash
docker compose up -d
```
### Instalação das dependencia
```bash
docker-compose exec laravel.test composer install
```
### Subindo containes do laravel
```bash
./vendor/bin/sail up -d
```
### Gere a chave da aplicação
```bash
./vendor/bin/sail artisan key:generate
```
### Execute as migrações
```bash
./vendor/bin/sail artisan migrate
```
