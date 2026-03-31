# Docker From Scratch For Your Yii2 Project

This guide is for learning.

It is not just "copy and run".

The goal is:

- understand what Docker is
- understand why we use Docker for a Yii2 project
- understand what file to create first
- understand what every Docker file means
- understand how app, database, and phpMyAdmin connect
- understand how to explain this to someone else

This guide assumes you want to learn the setup manually.

---

## 1. First: What Problem Is Docker Solving?

Without Docker, if you want to share your Yii2 project with your friend, your friend must install:

- PHP
- Composer
- MySQL
- Apache or Nginx
- phpMyAdmin if needed
- correct PHP extensions
- maybe correct PHP version too

That causes many problems:

- your machine works, your friend's machine fails
- PHP version may be different
- MySQL settings may be different
- Apache config may be different
- one friend uses Windows, another uses Mac

Docker solves this by packaging the environment.

That means:

- same PHP version
- same MySQL version
- same ports
- same container setup

So Docker is not mainly for code.

Docker is for making the **environment repeatable**.

---

## 2. Basic Docker Concepts

Before writing files, you need 4 basic words:

### Image

An image is like a template or blueprint.

Examples:

- `php:8.4-apache`
- `mysql:8.0`
- `phpmyadmin:5-apache`

You do not "edit" an image directly.

You build or run from it.

### Container

A container is a running instance of an image.

Example:

- image = `mysql:8.0`
- running container = your project database service

### Dockerfile

A `Dockerfile` tells Docker how to build your custom image.

For example:

- start from PHP image
- install PHP extensions
- copy configuration

### docker-compose.yml

This file lets you run many services together.

For your Yii2 project, that means:

- app
- db
- phpmyadmin

Think of it as:

"start my whole project stack with one command"

---

## 3. What Services Does Your Yii2 Project Need?

For this restaurant project, you need at least:

### 1. App service

This runs:

- PHP
- Apache
- your Yii2 project files

### 2. Database service

This runs:

- MySQL

Because `Menu` and `Booking` data are stored in MySQL.

### 3. phpMyAdmin service

Optional, but helpful.

This gives you a browser GUI to inspect the database.

---

## 4. If You Were Doing It From Scratch, What Order Should You Follow?

This is the best learning order:

1. understand what services you need
2. create `Dockerfile`
3. create Apache vhost config
4. create `docker-compose.yml`
5. update Yii database config to support Docker
6. build containers
7. install Composer packages
8. run Yii migrations
9. test the app

This order is important.

Many beginners wrongly start by writing random `docker compose` code without understanding what each container is supposed to do.

---

## 5. Step 1: Create The Dockerfile

The Dockerfile is for your **app container**.

In your project, the file is:

- [Dockerfile](/c:/laragon/www/yii2-todo/Dockerfile)

Current content:

```dockerfile
FROM composer:2 AS composer

FROM php:8.4-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        libicu-dev \
        libonig-dev \
        libzip-dev \
        unzip \
    && docker-php-ext-install \
        intl \
        mbstring \
        pdo_mysql \
        zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/local/bin/composer
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
```

Now let us explain it line by line.

---

## 6. Understanding The Dockerfile Line By Line

### Line:

```dockerfile
FROM composer:2 AS composer
```

Meaning:

- use the official Composer image
- name this build stage `composer`

Why:

- later we copy the Composer binary from this image
- this is easier than manually installing Composer

### Line:

```dockerfile
FROM php:8.4-apache
```

Meaning:

- the real app container is based on PHP 8.4 with Apache included

Why:

- your current dependencies require PHP 8.4
- Apache serves the Yii2 website

### Block:

```dockerfile
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        libicu-dev \
        libonig-dev \
        libzip-dev \
        unzip \
```

Meaning:

- update package list inside the container
- install system packages needed by PHP extensions and Composer work

Why each one matters:

- `git`: useful for Composer and package fetching
- `libicu-dev`: needed for PHP `intl`
- `libonig-dev`: needed for `mbstring`
- `libzip-dev`: needed for `zip`
- `unzip`: needed by Composer for package extraction

### Block:

```dockerfile
    && docker-php-ext-install \
        intl \
        mbstring \
        pdo_mysql \
        zip \
```

Meaning:

- compile and install PHP extensions into the container

Why each one matters:

- `intl`: Yii or PHP libraries often rely on internationalization support
- `mbstring`: multi-byte string support, very common in PHP apps
- `pdo_mysql`: required for MySQL database connection
- `zip`: required by many Composer workflows and libraries

### Line:

```dockerfile
    && a2enmod rewrite \
```

Meaning:

- enable Apache rewrite module

Why:

- Yii pretty URLs often rely on URL rewriting
- without this, routing may not work cleanly

### Line:

```dockerfile
    && rm -rf /var/lib/apt/lists/*
```

Meaning:

- cleanup package cache

Why:

- makes the image smaller

### Line:

```dockerfile
COPY --from=composer /usr/bin/composer /usr/local/bin/composer
```

Meaning:

- copy Composer executable from the first stage into the PHP container

Why:

- now inside the app container, you can run `composer install`

### Line:

```dockerfile
COPY docker/apache-vhost.conf /etc/apache2/sites-available/000-default.conf
```

Meaning:

- replace the default Apache site config with your own config

Why:

- Yii public entry point is inside the `web/` folder
- Apache must point to `web/`, not the project root

### Line:

```dockerfile
WORKDIR /var/www/html
```

Meaning:

- this becomes the default working folder inside the container

Why:

- your project files will be mounted there
- commands like `composer install` will run from the project root

---

## 7. Step 2: Create Apache Config

The Apache config file is:

- [apache-vhost.conf](/c:/laragon/www/yii2-todo/docker/apache-vhost.conf)

Current content:

```apache
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/web

    <Directory /var/www/html/web>
        AllowOverride All
        Require all granted
        Options Indexes FollowSymLinks
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Now the meaning.

### `DocumentRoot /var/www/html/web`

This is the most important line.

Why:

- Yii entry file is [index.php](/c:/laragon/www/yii2-todo/web/index.php)
- browser must enter through the `web` folder
- never point Apache to the whole project root for Yii basic app

### `<Directory /var/www/html/web>`

This defines permissions and behavior for that folder.

### `AllowOverride All`

Allows `.htaccess` rules to work.

Useful for Yii URL rewriting.

### `Require all granted`

Allows access to that directory from the web server.

---

## 8. Step 3: Create docker-compose.yml

This file runs the full project stack.

Your file is:

- [docker-compose.yml](/c:/laragon/www/yii2-todo/docker-compose.yml)

Current content:

```yaml
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: yii2_restaurant_app
    depends_on:
      - db
    environment:
      YII_DB_HOST: db
      YII_DB_PORT: 3306
      YII_DB_NAME: yii2_todo
      YII_DB_USER: yii2user
      YII_DB_PASSWORD: yii2pass
    ports:
      - "8080:80"
    volumes:
      - ./:/var/www/html

  db:
    image: mysql:8.0
    container_name: yii2_restaurant_db
    restart: unless-stopped
    command: --default-authentication-plugin=mysql_native_password
    environment:
      MYSQL_DATABASE: yii2_todo
      MYSQL_USER: yii2user
      MYSQL_PASSWORD: yii2pass
      MYSQL_ROOT_PASSWORD: root
    ports:
      - "3307:3306"
    volumes:
      - db_data:/var/lib/mysql

  phpmyadmin:
    image: phpmyadmin:5-apache
    container_name: yii2_restaurant_phpmyadmin
    restart: unless-stopped
    depends_on:
      - db
    environment:
      PMA_HOST: db
      PMA_PORT: 3306
    ports:
      - "8081:80"

volumes:
  db_data:
```

Now let us explain service by service.

---

## 9. Understanding The `app` Service

### `app:`

This is your Yii2 website container.

### `build:`

This says:

"build this container using our local Dockerfile"

### `context: .`

Meaning:

- use current project folder as build context

### `dockerfile: Dockerfile`

Meaning:

- use the file named `Dockerfile`

### `container_name: yii2_restaurant_app`

This gives the running container a readable name.

### `depends_on: - db`

Meaning:

- Docker should start database service before app service

Important:

This does not always mean MySQL is fully ready.

It only means Docker starts that service first.

### `environment:`

These are environment variables passed into the container:

- `YII_DB_HOST: db`
- `YII_DB_PORT: 3306`
- `YII_DB_NAME: yii2_todo`
- `YII_DB_USER: yii2user`
- `YII_DB_PASSWORD: yii2pass`

Why:

- the Yii app needs DB connection settings
- inside Docker network, the database host is `db`

This is extremely important:

- outside Docker, you think of MySQL as `localhost`
- inside Docker, one container talks to another by service name

So the app container connects to MySQL using:

`db:3306`

not:

`localhost:3306`

### `ports: - "8080:80"`

Meaning:

- your computer's port `8080` maps to container port `80`

So:

- browser opens `http://localhost:8080`
- Docker forwards it to Apache inside container on port `80`

### `volumes: - ./:/var/www/html`

Meaning:

- mount your local project folder into the container

Why:

- if you edit files on your computer, the container sees the changes immediately
- no need to rebuild for every small code change

---

## 10. Understanding The `db` Service

### `image: mysql:8.0`

Use official MySQL 8 image.

### `container_name: yii2_restaurant_db`

Readable container name.

### `restart: unless-stopped`

Meaning:

- if container crashes or Docker restarts, try to start it again

### `command: --default-authentication-plugin=mysql_native_password`

This helps compatibility with tools and clients.

### `environment:`

These create the initial database and users:

- `MYSQL_DATABASE: yii2_todo`
- `MYSQL_USER: yii2user`
- `MYSQL_PASSWORD: yii2pass`
- `MYSQL_ROOT_PASSWORD: root`

This means on first startup:

- database `yii2_todo` is created
- user `yii2user` is created
- password is `yii2pass`
- MySQL root password is `root`

### `ports: - "3307:3306"`

Meaning:

- your host machine port `3307` maps to container MySQL port `3306`

Why not map to `3306:3306`?

Because your local machine may already use `3306` from Laragon or another MySQL.

So `3307` is safer.

### `volumes: - db_data:/var/lib/mysql`

Meaning:

- store database files in a Docker volume

Why:

- database data will survive container restarts
- if you stop and restart containers, your tables stay there

---

## 11. Understanding The `phpmyadmin` Service

### `image: phpmyadmin:5-apache`

This runs phpMyAdmin in Apache.

### `depends_on: - db`

phpMyAdmin needs the database service.

### `environment:`

- `PMA_HOST: db`
- `PMA_PORT: 3306`

Meaning:

- phpMyAdmin will connect to the MySQL container using service name `db`

### `ports: - "8081:80"`

Meaning:

- browser opens `http://localhost:8081`

This gives you phpMyAdmin UI.

---

## 12. Step 4: Why We Had To Change `config/db.php`

Your database config file is:

- [db.php](/c:/laragon/www/yii2-todo/config/db.php)

Current content:

```php
<?php

$dbHost = getenv('YII_DB_HOST') ?: 'localhost';
$dbPort = getenv('YII_DB_PORT') ?: '3306';
$dbName = getenv('YII_DB_NAME') ?: 'yii2_todo';
$dbUser = getenv('YII_DB_USER') ?: 'root';
$dbPassword = getenv('YII_DB_PASSWORD');

return [
    'class' => 'yii\db\Connection',
    'dsn' => "mysql:host={$dbHost};port={$dbPort};dbname={$dbName}",
    'username' => $dbUser,
    'password' => $dbPassword === false ? '' : $dbPassword,
    'charset' => 'utf8mb4',
];
```

### Why not keep the old version?

Old version was something like:

```php
'dsn' => 'mysql:host=localhost;dbname=yii2_todo',
'username' => 'root',
'password' => '',
```

That works in Laragon.

But inside Docker, `localhost` would mean:

"the app container itself"

That is wrong, because MySQL is in another container.

So we changed it to use environment variables.

### Why this is better

Now the same project can work in:

- Laragon
- Docker

How?

Because:

- if env variables exist, Yii uses Docker values
- if env variables do not exist, Yii falls back to `localhost`

This is a very important real-world practice.

---

## 13. Manual Build Workflow From Scratch

If you wanted to do the whole setup yourself manually, this is the exact workflow.

### Step 1

Install Docker Desktop.

### Step 2

In project root, create:

- `Dockerfile`
- `docker-compose.yml`
- `docker/apache-vhost.conf`

### Step 3

Edit `config/db.php` so it can read DB settings from environment variables.

### Step 4

Build and start the containers:

```powershell
docker compose up -d --build
```

### Step 5

Check containers:

```powershell
docker compose ps
```

### Step 6

Install dependencies inside app container:

```powershell
docker compose exec app composer install
```

### Step 7

Run migrations:

```powershell
docker compose exec app php yii migrate
```

### Step 8

Open browser:

- `http://localhost:8080`
- `http://localhost:8081`

---

## 14. How The Networking Works

This part is very important.

Inside Docker Compose, all services are on the same internal network.

That means:

- app can reach db using hostname `db`
- phpmyadmin can reach db using hostname `db`

This is why in `docker-compose.yml` we wrote:

```yaml
YII_DB_HOST: db
PMA_HOST: db
```

If you write `localhost` there, it will usually be wrong.

### Simple memory trick

- host machine to container: use `localhost:<mapped-port>`
- container to container: use service name like `db`

Examples:

From your browser:

- `localhost:8080`
- `localhost:8081`

From app container:

- `db:3306`

---

## 15. How To Explain This Setup To Your Friend

You can say:

> "The app runs in one container, MySQL runs in another container, and phpMyAdmin runs in another. Docker Compose connects them. The Yii app reads database settings from environment variables, so it knows to connect to the database container by service name."

Shorter version:

> "Docker lets us share the same PHP, MySQL, and Apache environment without asking everyone to configure everything manually."

---

## 16. Common Beginner Mistakes

### Mistake 1: Using `localhost` inside container-to-container connection

Wrong inside app container:

`localhost`

Correct:

`db`

### Mistake 2: Forgetting that Yii public folder is `web/`

Wrong Apache root:

`/var/www/html`

Correct:

`/var/www/html/web`

### Mistake 3: Forgetting PHP extensions

If `pdo_mysql` is missing, Yii cannot talk to MySQL.

### Mistake 4: Not running `composer install`

Without Composer dependencies, Yii app will not run.

### Mistake 5: Not running migrations

Database container exists, but tables do not.

So app still fails if migrations are missing.

---

## 17. How This Relates To Laravel

The Docker idea is the same for Laravel and Yii.

Both frameworks still need:

- PHP
- web server
- Composer
- database

The difference is mostly in project structure, not Docker concept.

For both frameworks:

- Dockerfile builds the PHP environment
- docker-compose.yml connects app and db
- environment variables provide database settings

So once you understand Docker for this Yii project, the same concept applies to Laravel too.

---

## 18. Best Way To Learn This Properly

Do not try to memorize the full YAML and Dockerfile immediately.

Instead learn it in this order:

1. understand why you need 3 services
2. understand why Apache must point to `web/`
3. understand why app container uses `db` as database host
4. understand why `config/db.php` must read environment variables
5. understand why `composer install` and `php yii migrate` are still needed

If you understand these 5 things, you already understand the real setup.

---

## 19. If You Want To Practice By Rebuilding It Yourself

Best exercise:

1. read this guide once
2. hide the current Docker files
3. recreate them yourself from memory
4. compare your version with the current files

That is the fastest way to really learn.

Do not worry if you cannot remember every line.

What matters is understanding the purpose of each line.

---

## 20. Final Summary

From scratch, Docker setup for this Yii2 project means:

1. create a PHP Apache container with Yii-required extensions
2. point Apache to the `web/` folder
3. create a MySQL container
4. create a phpMyAdmin container
5. connect them with Docker Compose
6. pass database settings through environment variables
7. update Yii `config/db.php` to read those values
8. install Composer packages
9. run migrations
10. open the site in browser

The most important ideas are:

- Docker packages the environment
- Compose connects multiple services
- service names are used for internal networking
- Yii must use environment-based DB config for Docker

If you want, the next best thing I can do is write a second file called:

`DOCKER_COMMANDS_EXPLAINED_ONE_BY_ONE.md`

That one would teach every command you will type, like:

- `docker compose up -d --build`
- `docker compose ps`
- `docker compose exec app composer install`
- `docker compose exec app php yii migrate`

with detailed explanation of each word in the command.
