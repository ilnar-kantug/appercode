# My Laravel 5.6 boilerplate

## Getting Started

Install all needed packages

```
composer install
```

Create .env file, type in DB connection data

Generate key for project

```
php artisan key:generate
```

Change permissions for common folders
```
make perm
```

Build docker environment. But before running this command change ports for services in docker-compose.yml if needed
```
make build-docker 
```

If any command doesn't work properly try it with sudo.

After instalation delete this README.md file if necessary.
