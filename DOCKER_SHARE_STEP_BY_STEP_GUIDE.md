# Docker Share Guide For This Yii2 Project

This guide teaches you how to share this Yii2 restaurant project with your friend using Docker.

The idea is:

- your friend does not need Laragon
- your friend does not need to set PHP manually
- your friend does not need to install MySQL manually
- Docker will run the app, database, and phpMyAdmin together

---

## 1. What I Prepared In This Project

I added these files for Docker:

- [docker-compose.yml](/c:/laragon/www/yii2-todo/docker-compose.yml)
- [Dockerfile](/c:/laragon/www/yii2-todo/Dockerfile)
- [docker/apache-vhost.conf](/c:/laragon/www/yii2-todo/docker/apache-vhost.conf)

I also updated the database config here:

- [db.php](/c:/laragon/www/yii2-todo/config/db.php)

Why that change was needed:

- in Laragon, your database host is usually `localhost`
- in Docker, your database host becomes `db`

So now the project can work in both cases:

- Laragon
- Docker

---

## 2. What Docker Will Run

When you start Docker for this project, it will run 3 services:

### `app`

This is the Yii2 PHP + Apache container.

It serves the website at:

`http://localhost:8080`

### `db`

This is the MySQL database container.

It is exposed at:

`localhost:3307`

Important:

- inside Docker, the app talks to MySQL using host name `db`
- outside Docker, tools can reach MySQL on port `3307`

### `phpmyadmin`

This is the database GUI in browser.

It will open at:

`http://localhost:8081`

---

## 3. Before You Start

Make sure you have these installed on your computer:

1. Docker Desktop
2. Git, or at least the project folder copied to your machine

### How to check Docker

Open terminal and run:

```powershell
docker --version
docker compose version
```

If both work, you are ready.

---

## 4. Very Important First Decision

You have 2 ways to share the project with your friend.

### Option A: Share the whole project folder

This is easiest.

Your friend gets:

- source code
- Docker files
- existing project structure

Then your friend runs Docker locally.

### Option B: Push to GitHub

This is cleaner for collaboration.

Your friend does:

```powershell
git clone <your-repository-url>
cd yii2-todo
```

If possible, I recommend Option B.

---

## 5. Step By Step: First Time Startup

Do these steps in the project root:

`c:\laragon\www\yii2-todo`

### Step 1: Open terminal in project folder

Example:

```powershell
cd c:\laragon\www\yii2-todo
```

### Step 2: Build and start containers

Run:

```powershell
docker compose up -d --build
```

What this does:

- builds the PHP Apache image
- downloads MySQL image
- downloads phpMyAdmin image
- starts all containers in background

### Step 3: Check containers are running

Run:

```powershell
docker compose ps
```

You should see:

- `app`
- `db`
- `phpmyadmin`

---

## 6. Install Composer Dependencies Inside Docker

Because this is a PHP project, the app needs `vendor/` dependencies.

Run:

```powershell
docker compose exec app composer install
```

What this does:

- installs Yii2 dependencies
- creates or updates the `vendor` folder
- makes the application runnable in the container

### If Composer asks about permissions or plugins

Usually just allow the normal Yii plugin configuration already in `composer.json`.

---

## 7. Run Database Migrations

Now create the tables in MySQL.

Run:

```powershell
docker compose exec app php yii migrate
```

When Yii asks:

`Apply the above migrations? (yes|no)`

Type:

```text
yes
```

This will create tables like:

- `menus`
- `bookings`
- `todo`

Even though `todo` is still present from earlier learning, your main app is the restaurant project.

---

## 8. Open The Project In Browser

After migration finishes, open:

### Website

`http://localhost:8080`

### phpMyAdmin

`http://localhost:8081`

phpMyAdmin login:

- Server: `db`
- Username: `root`
- Password: `root`

or you can use:

- Username: `yii2user`
- Password: `yii2pass`

Database name:

`yii2_todo`

---

## 9. How To Verify It Works

Do this simple test:

1. Open the home page
2. Add menu item to cart
3. Open cart
4. Go to checkout
5. Submit a booking/order
6. Open phpMyAdmin
7. Check table `bookings`

If you see a new row in `bookings`, the Docker setup works.

---

## 10. Useful Docker Commands

### Start project

```powershell
docker compose up -d
```

### Stop project

```powershell
docker compose down
```

### Rebuild project

```powershell
docker compose up -d --build
```

### See logs

```powershell
docker compose logs -f
```

### See app logs only

```powershell
docker compose logs -f app
```

### Open shell inside app container

```powershell
docker compose exec app bash
```

### Run Yii command

```powershell
docker compose exec app php yii
```

### Run migration again

```powershell
docker compose exec app php yii migrate
```

### Composer install again

```powershell
docker compose exec app composer install
```

---

## 11. If Your Friend Wants To Run It On Another PC

Your friend should do:

1. install Docker Desktop
2. get the project folder
3. open terminal in project folder
4. run `docker compose up -d --build`
5. run `docker compose exec app composer install`
6. run `docker compose exec app php yii migrate`
7. open `http://localhost:8080`

That is the whole workflow.

---

## 12. How This Works Internally

Let us make the Docker workflow easy to understand.

### `Dockerfile`

This builds the PHP app environment.

It installs:

- PHP 8.4
- Apache
- Composer
- PDO MySQL extension
- mbstring
- intl
- zip

Why:

- Yii2 needs PHP
- MySQL connection needs `pdo_mysql`
- Composer is needed for dependencies

### `docker-compose.yml`

This connects all containers together:

- app
- db
- phpmyadmin

So instead of manually installing services, Docker starts all of them as one project.

### `config/db.php`

This now reads environment variables.

That means:

- Laragon can still use `localhost`
- Docker can use `db`

This is the key reason the same Yii project can work in two environments.

---

## 13. Common Problems And Fixes

### Problem: Port 8080 already used

Fix:

Change this in [docker-compose.yml](/c:/laragon/www/yii2-todo/docker-compose.yml):

```yaml
ports:
  - "8080:80"
```

Example change:

```yaml
ports:
  - "8090:80"
```

Then open:

`http://localhost:8090`

### Problem: Port 8081 already used

Fix:

Change phpMyAdmin port:

```yaml
ports:
  - "8082:80"
```

### Problem: Port 3307 already used

Fix:

Change database port:

```yaml
ports:
  - "3308:3306"
```

### Problem: Database not ready yet

Sometimes MySQL takes a bit longer to start.

Wait a little, then run:

```powershell
docker compose exec app php yii migrate
```

again.

### Problem: `composer install` fails

Check internet connection first because Composer needs to download packages.

Then run:

```powershell
docker compose exec app composer install
```

again.

### Problem: app shows database connection error

Check:

1. containers are running
2. migration already ran
3. `db.php` is using Docker env values

Run:

```powershell
docker compose ps
docker compose logs -f db
```

---

## 14. Difference Between Docker And Laragon In Your Case

### Laragon

- installed directly on your Windows machine
- uses local PHP and MySQL
- easy for personal development

### Docker

- runs app in containers
- gives same environment to every developer
- easier to share with friend
- avoids "works on my machine" problem

This is exactly why Docker is useful for teamwork.

---

## 15. What I Recommend You Do Right Now

Follow these commands one by one:

```powershell
cd c:\laragon\www\yii2-todo
docker compose up -d --build
docker compose ps
docker compose exec app composer install
docker compose exec app php yii migrate
```

Then open:

- `http://localhost:8080`
- `http://localhost:8081`

---

## 16. What To Send Me So I Can Check

After each step, send me the result of:

1. `docker compose ps`
2. `docker compose exec app composer install`
3. `docker compose exec app php yii migrate`

If any step fails, send me the full error and I will help you fix it step by step.
