# Yii2 Database, PDO, Active Record, Migration, and phpMyAdmin Guide

This guide is for **beginner level**.

You asked how the database is integrated in your Yii project and whether phpMyAdmin is used.

Short answer:

- **Yes**, phpMyAdmin can be used to **view and manage** the database
- **No**, phpMyAdmin is **not** what connects your Yii app to MySQL
- Your Yii app connects using **PDO through Yii's database component**

---

## 1. Very simple overview

When a user fills a form in your Yii project, this is what happens:

1. user types data in browser
2. form sends data to Yii controller
3. controller loads data into model
4. model validates the data
5. Yii uses the database connection
6. Yii saves the data into MySQL
7. phpMyAdmin can be used to check whether the data is really in the database

So:

- **Yii = application logic**
- **PDO = connection technology**
- **MySQL = database**
- **phpMyAdmin = database GUI tool**

---

## 2. What is PDO

**PDO** means:

**PHP Data Objects**

It is the PHP system used to connect to databases like:

- MySQL
- PostgreSQL
- SQLite

In simple words:

PDO is the bridge between PHP and the database.

Yii does not make raw MySQL connections by itself.
Yii uses PHP's PDO underneath.

That is why your error message showed:

`PDOException`

That means:

- Yii tried to save data
- PDO sent SQL to MySQL
- MySQL rejected the invalid date value

---

## 3. Where the Yii database connection is configured

In your project, the database connection is configured in:

- [db.php](c:\laragon\www\yii2-todo\config\db.php#L3)

Your file currently looks like this:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2_todo',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```

---

## 4. What each database config line means

### `'class' => 'yii\db\Connection'`

This tells Yii:

"Use Yii's database connection class."

### `'dsn' => 'mysql:host=localhost;dbname=yii2_todo'`

This is the most important line.

It means:

- database type = `mysql`
- database server = `localhost`
- database name = `yii2_todo`

### `'username' => 'root'`

This is the MySQL username.

### `'password' => ''`

This is the MySQL password.

In Laragon, `root` with empty password is common for local development.

### `'charset' => 'utf8'`

This tells Yii what character encoding to use.

---

## 5. How `db.php` is used by Yii

Your main web config is:

- [web.php](c:\laragon\www\yii2-todo\config\web.php)

Inside it, Yii does this:

```php
$db = require __DIR__ . '/db.php';
```

Then later:

```php
'db' => $db,
```

That means:

1. Yii reads the DB settings from `db.php`
2. Yii registers them as the app's `db` component
3. You can access the database with:

```php
Yii::$app->db
```

This is the official Yii database connection for your app.

---

## 6. What `Yii::$app->db` means

`Yii::$app` is the main application object.

`Yii::$app->db` means:

"Give me the database connection component"

That DB component uses PDO internally.

So:

- `Yii::$app->db` = Yii database component
- inside it = PDO connection

---

## 7. How models use the database automatically

Your models like:

- [Booking.php](c:\laragon\www\yii2-todo\models\Booking.php#L22)
- [Menu.php](c:\laragon\www\yii2-todo\models\Menu.php)
- [Todo.php](c:\laragon\www\yii2-todo\models\Todo.php)

extend:

```php
yii\db\ActiveRecord
```

This is very important.

Because of that, Yii automatically knows:

- which table the model uses
- which DB connection to use
- how to insert / update / delete rows

Example from your `Booking` model:

```php
public static function tableName()
{
    return 'bookings';
}
```

This tells Yii:

"This model uses the `bookings` table."

---

## 8. How saving a booking works

Let us follow the booking save process in your project.

## Step 1: User opens booking form

The form is in:

- [booking/_form.php](c:\laragon\www\yii2-todo\views\booking\_form.php#L13)

It contains fields like:

- name
- email
- phone
- date
- time
- people
- message
- status

## Step 2: User submits form

The request goes to:

- [BookingController.php](c:\laragon\www\yii2-todo\controllers\BookingController.php#L65)

Inside `actionCreate()`:

```php
$model = new Booking();

if ($this->request->isPost) {
    if ($model->load($this->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->id]);
    }
}
```

## Step 3: `load()` puts form data into the model

Yii takes POST data and fills the `Booking` model attributes.

For example:

- form name input goes into `$model->name`
- form date input goes into `$model->date`

## Step 4: `save()` triggers validation

Before inserting into the database, Yii checks model rules.

Your rules are in:

- [Booking.php](c:\laragon\www\yii2-todo\models\Booking.php#L45)

Now the important date/time rules are:

```php
[['date'], 'date', 'format' => 'php:Y-m-d'],
[['time'], 'match', 'pattern' => '/^\d{2}:\d{2}(:\d{2})?$/'],
```

This protects the database from invalid values.

## Step 5: Yii uses Active Record + PDO

When validation passes:

- Active Record builds the SQL
- Yii sends the SQL through PDO
- MySQL inserts the row

That is why you saw SQL in the error message before.

---

## 9. Why your error happened before

The old problem was:

- `bookings.date` column type = MySQL `DATE`
- `bookings.time` column type = MySQL `TIME`
- your form used plain text input
- user entered values like:
  - date = `2/4`
  - time = `9`

But MySQL expects:

### For `DATE`

Format:

```text
YYYY-MM-DD
```

Example:

```text
2026-03-29
```

### For `TIME`

Format:

```text
HH:MM:SS
```

or sometimes browser gives:

```text
HH:MM
```

Example:

```text
09:00
```

So when MySQL received:

```text
2/4
```

it rejected it.

That is why PDO threw:

`SQLSTATE[22007]: Invalid datetime format`

---

## 10. How I fixed it

I fixed the booking flow in two places:

## A. I fixed the form input types

File:

- [booking/_form.php](c:\laragon\www\yii2-todo\views\booking\_form.php#L21)

Now the form uses:

```php
->input('date')
->input('time')
->input('number', ['min' => 1])
```

This means the browser helps the user send correct values.

## B. I fixed the model validation

File:

- [Booking.php](c:\laragon\www\yii2-todo\models\Booking.php#L45)

Now Yii checks:

- date must match `Y-m-d`
- time must match `HH:MM` or `HH:MM:SS`

## C. I normalized the time value

File:

- [Booking.php](c:\laragon\www\yii2-todo\models\Booking.php#L64)

If browser sends:

```text
09:00
```

Yii changes it into:

```text
09:00:00
```

before saving.

This makes it safer for MySQL `TIME` columns.

---

## 11. What is phpMyAdmin

phpMyAdmin is a **web-based GUI tool** for MySQL.

It lets you:

- view databases
- view tables
- insert rows manually
- delete rows
- run SQL queries
- inspect data

But phpMyAdmin is **not the database itself**.

And phpMyAdmin is **not the thing your Yii app uses to save data**.

Think of it like this:

- MySQL = the real database engine
- PDO = PHP connection system
- Yii = your application logic
- phpMyAdmin = admin control panel for looking at the database

---

## 12. So do we use phpMyAdmin?

### Yes, for:

- checking whether data was saved
- viewing the tables
- debugging bad records
- manually editing local data during development
- checking migrations result

### No, for:

- direct app-to-database connection
- form processing
- validation
- saving records from the Yii website

The Yii app uses:

- `config/db.php`
- `yii\db\Connection`
- PDO
- Active Record

not phpMyAdmin.

---

## 13. How to check your Yii database in phpMyAdmin

If you are using Laragon:

1. Start Laragon
2. Open phpMyAdmin from Laragon
3. Open database:

```text
yii2_todo
```

4. Open table:

```text
bookings
```

5. Try saving a booking from the Yii form
6. Refresh the table in phpMyAdmin
7. You should see the new row

Useful tables in your project:

- `bookings`
- `menus`
- `todo`
- `migration`

---

## 14. What is the `migration` table

Yii keeps track of migrations using the `migration` table.

That table records which migration files have already been run.

So if you run:

```powershell
php yii migrate
```

Yii checks:

- which migration files exist
- which ones already ran
- which ones still need to run

This helps Yii update your database structure safely.

---

## 15. What is a migration

A migration is a PHP file that changes database structure.

Example file:

- [m260318_044841_create_bookings_table.php](c:\laragon\www\yii2-todo\migrations\m260318_044841_create_bookings_table.php#L5)

This file creates the `bookings` table.

Inside it:

```php
$this->createTable('bookings', [
    'id' => $this->primaryKey(),
    'name' => $this->string()->notNull(),
    'date' => $this->date()->notNull(),
    'time' => $this->time()->notNull(),
]);
```

This means:

- table name = `bookings`
- `date` column type = `DATE`
- `time` column type = `TIME`

That is why the input format must match the database type.

---

## 16. How to create database structure in Yii

There are two common ways:

## Option A: Use migrations

Best practice.

Command:

```powershell
C:\laragon\bin\php\php-8.4.16-nts-Win32-vs17-x64\php.exe yii migrate
```

This applies all migration files.

## Option B: Use phpMyAdmin manually

Possible, but less professional for long-term development.

You can manually:

- create tables
- edit columns
- insert data

But migration is better because:

- changes are saved in code
- changes can be repeated
- team members can run the same structure

---

## 17. Best practice: migration vs phpMyAdmin

### Use migrations for:

- creating tables
- changing table structure
- adding columns
- changing indexes
- keeping database structure in source code

### Use phpMyAdmin for:

- viewing tables
- checking saved records
- quick debugging
- manual local testing

This is the best answer if someone asks:

"Should we use phpMyAdmin or migration?"

Answer:

> Use migration for database structure, use phpMyAdmin for inspection and debugging.

---

## 18. How to know if Yii is really connected to MySQL

There are several signs:

### 1. No DB connection error

If Yii can open menu/booking/todo pages without DB connection failure, that is a good sign.

### 2. Data can be saved

If create form inserts rows successfully, DB connection is working.

### 3. phpMyAdmin shows the inserted row

This confirms the data is really inside MySQL.

### 4. `config/db.php` points to a real existing database

In your case:

```text
dbname=yii2_todo
```

So that database must exist in MySQL.

---

## 19. Example: booking save explained in one sentence

You can say this in your presentation:

> In the Yii project, the booking form sends POST data to `BookingController`, the controller loads the data into the `Booking` Active Record model, the model validates the input, and Yii uses its configured PDO-based MySQL connection to insert the record into the `bookings` table. I use phpMyAdmin only to verify and inspect the saved data.

That is a very strong explanation.

---

## 20. Important files you should remember

### Database connection

- [config/db.php](c:\laragon\www\yii2-todo\config\db.php#L3)

### Main web config

- [config/web.php](c:\laragon\www\yii2-todo\config\web.php)

### Booking model

- [models/Booking.php](c:\laragon\www\yii2-todo\models\Booking.php#L22)

### Booking controller

- [controllers/BookingController.php](c:\laragon\www\yii2-todo\controllers\BookingController.php#L65)

### Booking form

- [views/booking/_form.php](c:\laragon\www\yii2-todo\views\booking\_form.php#L13)

### Booking table migration

- [m260318_044841_create_bookings_table.php](c:\laragon\www\yii2-todo\migrations\m260318_044841_create_bookings_table.php#L5)

---

## 21. Common beginner misunderstanding

Many beginners think:

"I use phpMyAdmin, so my app saves through phpMyAdmin."

That is not correct.

Correct understanding:

- app saves through Yii + PDO + MySQL
- phpMyAdmin is only a viewer/editor tool for the database

---

## 22. Final summary

Here is the simplest final summary:

- Your Yii project is already connected to MySQL
- The connection is configured in `config/db.php`
- Yii uses `yii\db\Connection`
- Under the hood, Yii uses PDO
- Your models use Active Record to save data
- Your booking error happened because the input format did not match MySQL `DATE` and `TIME`
- I fixed that by improving the form and model validation
- phpMyAdmin is useful for checking data, but it is not the thing that connects the app to the database

---

## 23. Best next step for you

After reading this, try this practical exercise:

1. Open booking create page
2. Create one booking using the new date and time inputs
3. Open phpMyAdmin
4. Open database `yii2_todo`
5. Open table `bookings`
6. Confirm the row exists
7. Compare the saved values with the form inputs

That is the fastest way to truly understand the full flow.

