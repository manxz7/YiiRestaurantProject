# Phase 3: Yii Framework Mastery

This file explains your Yii2 project in very simple language.

If you are zero knowledge, do not worry.
Read this file slowly from top to bottom.

---

## 1. What this project is

This project is a **Yii2 web application**.

It now has:

- A public restaurant-style homepage using the `Yummy Red` template
- A `Todo` module
- A `Menu` module
- A `Booking` module
- A `Contact` form
- A custom Yii component called `restaurantInfo`

So this is not just a static website anymore.
It is a real Yii app with:

- routes
- controllers
- models
- views
- configuration
- database access
- widgets
- components

---

## 2. Your Phase 3 checklist status

### Completed in this project

- [x] Gii Tool
- [x] Active Record
- [x] Widgets
- [x] Components
- [x] Configuration
- [x] Mini-task: To-Do List in Yii

### Why I marked them complete

- `Gii Tool`
  Gii is already enabled in your Yii dev configuration.
  Your CRUD structure for `Menu` and `Booking` clearly follows Gii-generated Yii style.

- `Active Record`
  Your models `Todo`, `Menu`, and `Booking` all use Yii Active Record.

- `Widgets`
  Your project uses `GridView`, `DetailView`, `ActiveForm`, and `Captcha`.

- `Components`
  I added a custom component named `restaurantInfo` and connected it through `Yii::$app`.

- `Configuration`
  Your app uses `config/web.php`, `config/console.php`, and `config/db.php`.

- `Mini-task`
  Your `Todo` CRUD already exists and works as the Yii version of a to-do list.

---

## 3. The most important Yii idea

Yii follows the **MVC pattern**:

- `M = Model`
- `V = View`
- `C = Controller`

### Very simple meaning

- **Model**
  Handles data and rules
  Example: `models/Todo.php`

- **View**
  Handles HTML and what the user sees
  Example: `views/todo/index.php`

- **Controller**
  Handles user requests and decides what to do
  Example: `controllers/TodoController.php`

### Example flow

When user opens:

`/todo/index`

Yii usually does this:

1. Route goes to `TodoController`
2. `actionIndex()` runs
3. Controller asks model for data
4. Controller sends that data into a view
5. View shows HTML to the browser

---

## 4. Project structure explained

### `controllers/`

This folder contains the logic that responds to URLs.

Important files:

- `controllers/SiteController.php`
- `controllers/TodoController.php`
- `controllers/MenuController.php`
- `controllers/BookingController.php`

### `models/`

This folder contains database logic and validation rules.

Important files:

- `models/Todo.php`
- `models/Menu.php`
- `models/Booking.php`
- `models/ContactForm.php`
- `models/LoginForm.php`

### `views/`

This folder contains the page templates.

Important folders:

- `views/site/`
- `views/todo/`
- `views/menu/`
- `views/booking/`
- `views/layouts/`

### `config/`

This folder contains app settings.

Important files:

- `config/web.php`
- `config/console.php`
- `config/db.php`
- `config/params.php`

### `assets/`

This contains Yii asset bundle classes.

Important file:

- `assets/YummyAsset.php`

### `components/`

This contains reusable custom application logic.

Important file:

- `components/RestaurantInfo.php`

### `web/`

This is the public web root.

Important files and folders:

- `web/index.php`
- `web/yummy-red/`

---

## 5. Gii Tool

## What Gii is

**Gii** is Yii's code generator.

It can automatically create:

- Models
- CRUD
- Forms
- Controllers
- Search models
- Views

This saves time and helps you learn the Yii structure.

## Is Gii already enabled here

Yes.

In `config/web.php` for development mode:

- `debug` module is enabled
- `gii` module is enabled

In `config/console.php`:

- `gii` is also enabled for dev

## How to open Gii

If your local site is running in dev mode, open:

`http://your-local-domain/index.php?r=gii`

or with pretty URL if configured correctly:

`http://your-local-domain/gii`

## How to use Gii for CRUD

Example idea:

1. Create a database table first
2. Open Gii
3. Choose `Model Generator`
4. Generate a model from the table
5. Choose `CRUD Generator`
6. Generate controller + views

## What Gii probably generated in your project

The structure of `Menu` and `Booking` looks like Gii-generated CRUD:

- controller
- `_form.php`
- `create.php`
- `update.php`
- `index.php`
- `view.php`

That is good, because it teaches the default Yii pattern.

## Important warning

Gii helps you start fast, but you must still:

- clean the generated code
- improve validation rules
- improve UI
- remove fields users should not edit directly

You already saw this in your project when `created_at` and `updated_at` were wrongly shown in forms.

---

## 6. Active Record

## What Active Record means

In Yii, **Active Record** means one PHP model class usually represents one database table.

Example:

- table `todo` -> model `Todo`
- table `menus` -> model `Menu`
- table `bookings` -> model `Booking`

## Where you use it

### `models/Todo.php`

This class extends:

`yii\db\ActiveRecord`

That means Yii gives it database abilities automatically.

## Common Active Record methods

### Read all rows

```php
Todo::find()->all();
```

### Read one row

```php
Todo::findOne($id);
```

### Create new row

```php
$model = new Todo();
$model->title = 'Buy milk';
$model->save();
```

### Update row

```php
$model = Todo::findOne($id);
$model->title = 'Buy coffee';
$model->save();
```

### Delete row

```php
$model = Todo::findOne($id);
$model->delete();
```

## How this compares to Laravel

If you know Laravel:

- Yii `ActiveRecord` is similar to Laravel `Eloquent`
- Yii model rules are like validation rules attached to the model
- Yii uses `find()`, `findOne()`, `save()`, `delete()`

Simple comparison:

- Laravel: `Todo::all()`
- Yii: `Todo::find()->all()`

- Laravel: `Todo::find($id)`
- Yii: `Todo::findOne($id)`

## Why Active Record is important in your project

Your controllers depend on it.

Example:

- `TodoController` uses `Todo::find()`
- `MenuController` uses `Menu::find()`
- `BookingController` uses `Booking::find()`

Without Active Record, the CRUD pages would not work.

---

## 7. Widgets

## What a widget is

A **widget** in Yii is a reusable mini-UI component written in PHP.

Instead of writing raw HTML for everything, Yii gives you widgets.

## Widgets already used in your project

### `GridView`

Used in:

- `views/todo/index.php`
- `views/menu/index.php`
- `views/booking/index.php`

Purpose:

- shows table/list data
- supports columns
- supports action buttons

Example idea:

```php
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => ['id', 'title'],
]);
```

### `DetailView`

Used in:

- `views/todo/view.php`
- `views/menu/view.php`
- `views/booking/view.php`

Purpose:

- shows one record in detail

### `ActiveForm`

Used in:

- `_form.php` files
- `views/site/contact.php`
- `views/site/login.php`

Purpose:

- builds forms
- connects input fields to model attributes

### `Captcha`

Used in:

- `views/site/contact.php`

Purpose:

- adds bot protection

## Why widgets matter

Widgets are one of the things that make Yii feel very "Yii".

Instead of manually building everything:

- Yii gives you reusable blocks
- less code
- faster CRUD
- cleaner structure

---

## 8. Components and `Yii::$app`

## What `Yii::$app` is

`Yii::$app` is the **main application object**.

You can think of it as:

"the central control box of the whole app"

It gives access to important components such as:

- request
- response
- db
- user
- session
- mailer
- cache
- params

## Examples

### Current request

```php
Yii::$app->request
```

### Database connection

```php
Yii::$app->db
```

### Logged-in user

```php
Yii::$app->user
```

### Session flash messages

```php
Yii::$app->session
```

## What I added to your project

I added a custom component:

- `components/RestaurantInfo.php`

It is registered inside:

- `config/web.php`

with the component name:

`restaurantInfo`

That means you can access it like this:

```php
Yii::$app->restaurantInfo
```

## Real examples from your project now

### Phone number

```php
Yii::$app->restaurantInfo->phone
```

### Email

```php
Yii::$app->restaurantInfo->email
```

### Reservation summary

```php
Yii::$app->restaurantInfo->reservationSummary
```

This is a very good learning example because it shows:

- how to create your own component
- how to configure it
- how to use it in views

---

## 9. Configuration

## Main config files

### `config/web.php`

This is the main configuration for the web app.

It controls things like:

- app name
- components
- db
- routing
- mailer
- debug
- gii

### `config/console.php`

This is configuration for command-line Yii usage.

Used for:

- migrations
- console commands
- Gii in console context

### `config/db.php`

This holds the database connection settings:

- host
- database name
- username
- password

## Important idea

In your `config/web.php`, you do this:

```php
$db = require __DIR__ . '/db.php';
```

Then later:

```php
'db' => $db,
```

This means the DB configuration is kept separate and then inserted into the main config.

That is a clean Yii style.

## Why configuration matters

If config is wrong:

- app cannot connect to database
- Gii may fail
- login may fail
- routes may fail
- assets may fail

So configuration is one of the first places to check when a Yii project is broken.

---

## 10. Mini-task: To-Do List in Yii

This is already done in your project.

The Yii version of the to-do list is:

- `models/Todo.php`
- `controllers/TodoController.php`
- `views/todo/*`

## What this teaches you

The Todo module is the best beginner example because it is simple.

It teaches:

- routing
- controller actions
- Active Record
- forms
- validation
- GridView
- DetailView
- create / read / update / delete

## Why this is useful

If you compare it with Laravel:

- Laravel has routes file + controller + model + blade
- Yii often follows controller/action routing + model + view

By reading the Todo module first, you can understand the rest of the app much more easily.

---

## 11. How one CRUD module works in this project

Let us use `Todo` as example.

## Step 1: User opens the page

User visits:

`/todo/index`

## Step 2: Controller runs

Yii uses:

- `controllers/TodoController.php`

Then:

- `actionIndex()` runs

## Step 3: Model gets data

Inside the controller:

- `Todo::find()` gets query data from the database

## Step 4: DataProvider prepares data

Yii wraps query results in:

- `ActiveDataProvider`

This is useful because widgets like `GridView` understand it.

## Step 5: View displays data

The view:

- `views/todo/index.php`

uses:

- `GridView::widget(...)`

to display the records.

## Step 6: User clicks one item

Yii goes to:

`/todo/view?id=1`

Then:

- controller loads one record
- `views/todo/view.php` shows it with `DetailView`

## Step 7: User clicks create or update

Yii uses:

- `views/todo/_form.php`

and `ActiveForm`

This is why Yii CRUD feels very structured.

---

## 12. Validation rules

In Yii, validation is often placed inside the model.

Example from your project:

```php
public function rules()
{
    return [
        [['title'], 'required'],
        [['description'], 'string'],
    ];
}
```

This means:

- `title` must be filled
- `description` must be text

## Why this is good

The same rules help both:

- form validation
- save validation

So the model protects your data.

---

## 13. Timestamp behavior

Your `Todo`, `Menu`, and `Booking` models use:

`TimestampBehavior`

This automatically fills:

- `created_at`
- `updated_at`

without asking the user to type those values.

This is a good example of Yii behavior reuse.

---

## 14. Asset bundles

Yii uses **asset bundles** to manage CSS and JavaScript.

In your project:

- `assets/YummyAsset.php`

registers the imported template files.

That includes:

- Bootstrap
- Bootstrap Icons
- AOS
- GLightbox
- Swiper
- main template CSS
- main template JS

This is the Yii way to load frontend assets cleanly.

---

## 15. Layouts

A layout is the outer shell of the page.

Your main layout is:

- `views/layouts/main.php`

This file contains:

- header
- navigation
- footer
- asset registration
- page wrapper

Then Yii inserts the current page content inside that layout.

So:

- layout = outer frame
- view = page content

---

## 16. Suggestions to improve your learning even more

These are my suggestions for your next step:

### 1. Use Gii to generate a Search Model

Why:

- then your `GridView` pages can have filters
- this teaches a more complete Yii CRUD flow

### 2. Add relationships between models

Example idea:

- a booking can belong to a customer
- a menu item can belong to a category table

Why:

- this teaches `hasOne()` and `hasMany()`

### 3. Learn migrations properly

You already have migrations.
Next, focus on understanding:

- `up()`
- `down()`
- `yii migrate`

### 4. Create a custom console command

Why:

- teaches console config
- teaches reusable automation in Yii

### 5. Create one API endpoint

Example:

- `/api/menu`

Why:

- helps you understand Yii responses and JSON output

---

## 17. Best learning order for you

If you are starting from zero, study in this order:

1. `models/Todo.php`
2. `controllers/TodoController.php`
3. `views/todo/index.php`
4. `views/todo/view.php`
5. `views/todo/_form.php`
6. `config/web.php`
7. `models/Menu.php`
8. `controllers/MenuController.php`
9. `views/layouts/main.php`
10. `components/RestaurantInfo.php`

Why this order:

- Todo is the smallest complete example
- then you move to bigger CRUD modules
- then you learn layout and components

---

## 18. Important commands you should know

### Run migrations

```powershell
C:\laragon\bin\php\php-8.4.16-nts-Win32-vs17-x64\php.exe yii migrate
```

### Open Gii through browser

Use your local dev domain and open:

```text
/gii
```

### Run Yii console help

```powershell
C:\laragon\bin\php\php-8.4.16-nts-Win32-vs17-x64\php.exe yii
```

Note:
Use PHP 8.4 for this project because your installed dependencies were built for PHP 8.4.

---

## 19. Very short summary

What you already achieved:

- You have a real Yii2 CRUD app
- You have used Active Record
- You have used GridView and DetailView
- You have used `Yii::$app`
- You have app configuration files
- You have a Yii to-do list
- You have a custom component
- You have a themed frontend integrated through Yii assets and layout

That means your Phase 3 is not just theory anymore.
It is now implemented in your actual project.

---

## 20. Final advice from me

Do not try to memorize Yii all at once.

Instead, repeat this loop:

1. open one route
2. find its controller
3. find its model
4. find its view
5. change one small thing
6. reload browser

That is the fastest way to stop feeling lost.

If you want, my next step can be:

- create a second Markdown file that explains this entire project file-by-file
- or teach you the `Todo` module line by line like a classroom lesson

