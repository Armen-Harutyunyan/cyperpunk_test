# Cyperpunk Test

Bedrock-based WordPress project with a custom theme and a ready Docker setup.

## Stack

- PHP `8.3`
- WordPress `6.9.4`
- MariaDB `10.11`
- Nginx `1.27`
- Bedrock / Composer

## Requirements

- Docker Desktop or Docker Engine with Compose
- Free local port `8080`

No additional env file is required for Docker.  
`docker-compose.yml` already contains the runtime configuration for the containerized app.

If `8080` is busy, use another port:

```bash
APP_PORT=8090 docker compose up --build -d
```

## Quick Start

```bash
docker compose up --build -d
```

Open:

- Frontend: `http://localhost:8080`
- Admin: `http://localhost:8080/wp/wp-admin`
- Login: `http://localhost:8080/wp/wp-login.php`

## Admin Access

The imported database already contains an administrator:

- login: `admin`

If you need to reset the password:

```bash
docker compose exec db mariadb -uroot -proot test_cyberpank -e "UPDATE wp_users SET user_pass = MD5('admin') WHERE user_login = 'admin';"
```

## Database

The project includes a database dump:

- [docker/db/init/01-cyperpunk.sql.gz](/Users/armenharutyunyan/WebstormProjects/cyperpunk_test/docker/db/init/01-cyperpunk.sql.gz)

It is imported automatically on the first start of a fresh DB volume.

To re-import the database from scratch:

```bash
docker compose down -v
docker compose up --build -d
```

## Docker Files

- [docker-compose.yml](/Users/armenharutyunyan/WebstormProjects/cyperpunk_test/docker-compose.yml)
- [docker/php/Dockerfile](/Users/armenharutyunyan/WebstormProjects/cyperpunk_test/docker/php/Dockerfile)
- [docker/php/entrypoint.sh](/Users/armenharutyunyan/WebstormProjects/cyperpunk_test/docker/php/entrypoint.sh)
- [docker/php/conf.d/app.ini](/Users/armenharutyunyan/WebstormProjects/cyperpunk_test/docker/php/conf.d/app.ini)
- [docker/nginx/default.conf](/Users/armenharutyunyan/WebstormProjects/cyperpunk_test/docker/nginx/default.conf)

## Useful Commands

Start:

```bash
docker compose up --build -d
```

Stop:

```bash
docker compose down
```

Stop and remove database volume:

```bash
docker compose down -v
```

Logs:

```bash
docker compose logs -f
```

Open shell in PHP container:

```bash
docker compose exec app sh
```

## Local Debug Log

WordPress debug log is written to:

- [web/app/debug.log](/Users/armenharutyunyan/WebstormProjects/cyperpunk_test/web/app/debug.log)

## Notes

- Docker uses the values declared in `docker-compose.yml`
- The internal DB host inside Docker is `db`
- Composer dependencies are installed automatically in the PHP container if needed
