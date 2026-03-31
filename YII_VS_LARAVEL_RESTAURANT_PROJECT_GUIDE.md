# Yii2 vs Laravel for Your Restaurant Project

This guide is written for **beginner level**.

You told me this is the **same restaurant project**, but built in:

- **Yii2**
- **Laravel**

So this file will help you:

1. understand both frameworks
2. explain the differences clearly to your supervisor
3. know how development works in each framework
4. present your project with confidence

---

## 1. Big picture

Both Yii2 and Laravel are **PHP web frameworks**.

That means both help you build:

- dynamic websites
- CRUD systems
- forms
- database-based applications
- MVC architecture

In your case, both versions are used to build a **restaurant system** with things like:

- homepage
- menu management
- bookings
- contact form
- admin pages

So the main difference is **not the final goal**.
The main difference is **how each framework organizes the work**.

---

## 2. Very short framework summary

### Yii2

Yii2 is very structured and comes with strong built-in tools like:

- Gii code generator
- GridView
- DetailView
- ActiveForm
- built-in MVC conventions

Yii often feels:

- fast for CRUD
- very component-based
- very useful for admin-style systems

### Laravel

Laravel is also MVC, but it feels more modern and expressive in syntax.

Laravel is famous for:

- elegant routing
- Blade templating
- Eloquent ORM
- validation in controllers or form requests
- big ecosystem

Laravel often feels:

- very developer-friendly
- very readable
- popular for modern web development

---

## 3. Your two project versions

## Yii2 version

Your Yii2 project is in:

- [yii2-todo](c:\laragon\www\yii2-todo)

Important Yii files:

- [web/index.php](c:\laragon\www\yii2-todo\web\index.php)
- [config/web.php](c:\laragon\www\yii2-todo\config\web.php)
- [controllers/SiteController.php](c:\laragon\www\yii2-todo\controllers\SiteController.php)
- [controllers/TodoController.php](c:\laragon\www\yii2-todo\controllers\TodoController.php)
- [models/Todo.php](c:\laragon\www\yii2-todo\models\Todo.php)
- [views/layouts/main.php](c:\laragon\www\yii2-todo\views\layouts\main.php)

## Laravel version

Your Laravel version is in:

- [RestaurantTask2](c:\laragon\www\yii2-todo\RestaurantTask2)

Important Laravel files:

- [public/index.php](c:\laragon\www\yii2-todo\RestaurantTask2\public\index.php)
- [bootstrap/app.php](c:\laragon\www\yii2-todo\RestaurantTask2\bootstrap\app.php)
- [routes/web.php](c:\laragon\www\yii2-todo\RestaurantTask2\routes\web.php)
- [app/Http/Controllers/PageController.php](c:\laragon\www\yii2-todo\RestaurantTask2\app\Http\Controllers\PageController.php)
- [app/Http/Controllers/AdminController.php](c:\laragon\www\yii2-todo\RestaurantTask2\app\Http\Controllers\AdminController.php)
- [app/Models/Menu.php](c:\laragon\www\yii2-todo\RestaurantTask2\app\Models\Menu.php)
- [resources/views/layouts/app.blade.php](c:\laragon\www\yii2-todo\RestaurantTask2\resources\views\layouts\app.blade.php)

---

## 4. Same concept, different style

Here is the easiest way to explain both frameworks:

### Same idea

Both frameworks do this:

1. receive request from browser
2. send request to controller
3. controller gets data from model
4. controller sends data to view
5. view returns HTML

### Different style

The architecture is similar, but the coding style is different:

- Yii2 is more **widget + configuration + convention** oriented
- Laravel is more **route + controller + Blade** oriented

This is one of the best one-line explanations for presentation.

---

## 5. How request flow works

## Yii2 request flow

Look at:

- [web/index.php](c:\laragon\www\yii2-todo\web\index.php)

Yii2 boot process in your project:

1. load Composer autoload
2. load Yii core
3. load `config/web.php`
4. create `yii\web\Application`
5. run application

So Yii2 entry point is very direct:

```php
$config = require __DIR__ . '/../config/web.php';
(new yii\web\Application($config))->run();
```

## Laravel request flow

Look at:

- [bootstrap/app.php](c:\laragon\www\yii2-todo\RestaurantTask2\bootstrap\app.php)

Laravel boot process in your project:

1. configure the application
2. load routes
3. load middleware
4. load exception handling
5. create application instance

Laravel feels more pipeline-based and bootstrapped through the framework container.

---

## 6. Routing difference

This is one of the most important differences.

## Laravel routing

In Laravel, routes are usually written very clearly in:

- [routes/web.php](c:\laragon\www\yii2-todo\RestaurantTask2\routes\web.php)

Example:

```php
Route::get('/', [PageController::class, 'home']);
Route::post('/booking', [PageController::class, 'storeBooking']);
```

This means:

- when user opens `/`
- Laravel calls `PageController@home`

Laravel routing is explicit and easy to read.

## Yii2 routing

In Yii2, routing is usually based on:

- controller name
- action name

Configured in:

- [config/web.php](c:\laragon\www\yii2-todo\config\web.php)

Example Yii route pattern:

- `/todo/index`
- `/menu/create`
- `/booking/view?id=1`

These map to:

- `TodoController::actionIndex()`
- `MenuController::actionCreate()`
- `BookingController::actionView($id)`

## Main difference

### Laravel

You define routes manually in a route file.

### Yii2

Routes are often inferred from controller/action naming, with URL manager rules helping format the URL.

## Easy sentence for presentation

Laravel gives me **more explicit routing**, while Yii gives me **controller-action style routing with centralized config**.

---

## 7. Controller difference

## Laravel controllers

Examples:

- [PageController.php](c:\laragon\www\yii2-todo\RestaurantTask2\app\Http\Controllers\PageController.php)
- [AdminController.php](c:\laragon\www\yii2-todo\RestaurantTask2\app\Http\Controllers\AdminController.php)

Laravel controller style:

- route goes to controller method
- validation often happens inside controller
- then model is used
- then `view(...)` or `redirect(...)`

Example:

```php
return view('pages.home', compact('menus'));
```

## Yii2 controllers

Examples:

- [SiteController.php](c:\laragon\www\yii2-todo\controllers\SiteController.php)
- [TodoController.php](c:\laragon\www\yii2-todo\controllers\TodoController.php)

Yii controller style:

- action methods usually start with `action`
- uses `$this->render(...)`
- often uses model-based validation

Example:

```php
return $this->render('index', [
    'featuredMenus' => $featuredMenus,
]);
```

## Main difference

### Laravel

Controller methods are named normally:

- `home()`
- `storeBooking()`
- `menus()`

### Yii2

Controller methods follow action style:

- `actionIndex()`
- `actionCreate()`
- `actionUpdate()`

## Easy sentence for presentation

Laravel controllers feel more custom and route-driven, while Yii controllers feel more CRUD-oriented and convention-based.

---

## 8. Model difference: Eloquent vs Active Record

This is one of the biggest concept differences.

## Laravel uses Eloquent

Examples:

- [app/Models/Menu.php](c:\laragon\www\yii2-todo\RestaurantTask2\app\Models\Menu.php)
- [app/Models/Booking.php](c:\laragon\www\yii2-todo\RestaurantTask2\app\Models\Booking.php)

Laravel model:

```php
class Menu extends Model
{
    protected $fillable = [...];
}
```

Important Laravel idea:

- `$fillable` is used for **mass assignment protection**

This tells Laravel which fields are allowed to be inserted by:

```php
Menu::create([...]);
```

## Yii2 uses Active Record

Examples:

- [models/Menu.php](c:\laragon\www\yii2-todo\models\Menu.php)
- [models/Booking.php](c:\laragon\www\yii2-todo\models\Booking.php)
- [models/Todo.php](c:\laragon\www\yii2-todo\models\Todo.php)

Yii model:

```php
class Menu extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'menus';
    }
}
```

Important Yii idea:

- model contains `rules()`
- validation is strongly model-centered

## Comparing database create

### Laravel

```php
Booking::create([
    'name' => $request->name,
]);
```

### Yii2

```php
$model = new Booking();
$model->load(Yii::$app->request->post());
$model->save();
```

## Main difference

### Laravel

Usually relies on:

- Eloquent
- `$fillable`
- request validation

### Yii2

Usually relies on:

- Active Record
- model `rules()`
- model `load()` and `save()`

## Easy sentence for presentation

Laravel Eloquent is very expressive and often works closely with the request object, while Yii Active Record is more tightly integrated with model validation and form handling.

---

## 9. Validation difference

## Laravel validation

In your Laravel project, validation is inside controller methods like:

- `storeBooking(Request $request)`
- `storeContact(Request $request)`

Example:

```php
$request->validate([
    'name' => 'required|string|max:255',
]);
```

This is very common in Laravel.

## Yii2 validation

In Yii2, validation rules are usually inside the model:

- [models/Booking.php](c:\laragon\www\yii2-todo\models\Booking.php)
- [models/Menu.php](c:\laragon\www\yii2-todo\models\Menu.php)
- [models/Todo.php](c:\laragon\www\yii2-todo\models\Todo.php)

Example idea:

```php
public function rules()
{
    return [
        [['name', 'email'], 'required'],
        ['email', 'email'],
    ];
}
```

## Main difference

### Laravel

Validation is often request/controller-first.

### Yii2

Validation is often model-first.

## Easy sentence for presentation

Laravel usually validates input in the controller or request layer, while Yii usually validates inside the model itself.

---

## 10. View difference: Blade vs PHP views

## Laravel views

Laravel uses **Blade** templates.

Examples:

- [resources/views/layouts/app.blade.php](c:\laragon\www\yii2-todo\RestaurantTask2\resources\views\layouts\app.blade.php)
- [resources/views/pages/home.blade.php](c:\laragon\www\yii2-todo\RestaurantTask2\resources\views\pages\home.blade.php)

Blade syntax examples:

```blade
@extends('layouts.app')
@section('content')
@foreach($items as $item)
{{ $item->name }}
@endforeach
```

Blade is a template language on top of PHP.

## Yii2 views

Yii views are usually plain PHP files.

Examples:

- [views/layouts/main.php](c:\laragon\www\yii2-todo\views\layouts\main.php)
- [views/site/index.php](c:\laragon\www\yii2-todo\views\site\index.php)

Yii syntax examples:

```php
<?= Html::encode($model->name) ?>
<?php foreach ($items as $item): ?>
<?php endforeach; ?>
```

## Main difference

### Laravel Blade

- cleaner for HTML templating
- easier to read for many developers

### Yii PHP views

- more direct PHP
- often paired with helper classes and widgets

## Easy sentence for presentation

Laravel uses Blade, which is a dedicated template syntax, while Yii uses standard PHP-based views with helper classes and widgets.

---

## 11. Widgets vs manual UI building

This is a strong Yii feature difference.

## Yii widgets

Your Yii app uses:

- `GridView`
- `DetailView`
- `ActiveForm`
- `Captcha`

These are ready-made UI building blocks.

Examples:

- [views/todo/index.php](c:\laragon\www\yii2-todo\views\todo\index.php)
- [views/todo/view.php](c:\laragon\www\yii2-todo\views\todo\view.php)
- [views/site/contact.php](c:\laragon\www\yii2-todo\views\site\contact.php)

## Laravel UI style

Your Laravel app mostly builds UI manually in Blade:

- loops
- HTML
- forms
- session messages

Laravel can also use components, but in your current project it mostly uses direct Blade + HTML.

## Main difference

### Yii2

Better built-in admin widgets out of the box.

### Laravel

Usually more manual unless you add packages or create your own components.

## Easy sentence for presentation

Yii is stronger in built-in CRUD widgets, while Laravel gives more freedom but often requires more manual view work.

---

## 12. Database configuration difference

## Yii2 database config

Files:

- [config/db.php](c:\laragon\www\yii2-todo\config\db.php)
- [config/web.php](c:\laragon\www\yii2-todo\config\web.php)

Yii style:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2_todo',
    'username' => 'root',
    'password' => '',
];
```

Then included into `web.php`.

## Laravel database config

Files:

- [config/database.php](c:\laragon\www\yii2-todo\RestaurantTask2\config\database.php)
- `.env`

Laravel style:

- config file defines many possible database connections
- actual active values usually come from `.env`

Example:

```php
'default' => env('DB_CONNECTION', 'sqlite')
```

and:

```php
'host' => env('DB_HOST', '127.0.0.1')
```

## Main difference

### Laravel

Very `.env` driven.

### Yii2

More direct PHP array config in project config files.

## Easy sentence for presentation

Laravel separates environment settings heavily through `.env`, while Yii often uses direct PHP config arrays, sometimes split into files like `db.php`.

---

## 13. Migration difference

Both projects use migrations.

## Laravel migration

Example:

- [2026_03_11_013501_create_bookings_table.php](c:\laragon\www\yii2-todo\RestaurantTask2\database\migrations\2026_03_11_013501_create_bookings_table.php)

Laravel style:

```php
Schema::create('bookings', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});
```

This automatically creates:

- `created_at`
- `updated_at`

with `$table->timestamps()`

## Yii2 migration

Example:

- [m260318_044841_create_bookings_table.php](c:\laragon\www\yii2-todo\migrations\m260318_044841_create_bookings_table.php)

Yii style:

```php
$this->createTable('bookings', [
    'id' => $this->primaryKey(),
    'name' => $this->string()->notNull(),
]);
```

In Yii, timestamps were created manually:

- `created_at`
- `updated_at`

## Main difference

### Laravel

Migration syntax feels more fluent and includes shortcuts like `timestamps()`.

### Yii2

Migration syntax is also clean, but usually more explicit.

---

## 14. Form handling difference

## Laravel form handling

In your Laravel project:

- forms are mostly plain HTML inside Blade
- CSRF is added by `@csrf`
- form submits to explicit route

Example:

```blade
<form action="/booking" method="POST">
    @csrf
</form>
```

## Yii2 form handling

In Yii2:

- forms often use `ActiveForm`
- fields are linked directly to model attributes

Example:

```php
$form = ActiveForm::begin();
echo $form->field($model, 'name');
ActiveForm::end();
```

## Main difference

### Laravel

Form is more HTML-first.

### Yii2

Form is more model-first.

## Easy sentence for presentation

Laravel forms are usually hand-written in Blade, while Yii forms are often generated and connected directly to model fields through ActiveForm.

---

## 15. Layout system difference

## Laravel

Your Laravel layout:

- [resources/views/layouts/app.blade.php](c:\laragon\www\yii2-todo\RestaurantTask2\resources\views\layouts\app.blade.php)

Uses:

```blade
@yield('content')
```

Child views use:

```blade
@extends('layouts.app')
@section('content')
```

## Yii2

Your Yii layout:

- [views/layouts/main.php](c:\laragon\www\yii2-todo\views\layouts\main.php)

Yii inserts page content using:

```php
<?= $content ?>
```

## Main difference

### Laravel

Template inheritance with Blade directives.

### Yii2

Layout rendering with PHP variables and `render()` process.

---

## 16. Component / service access difference

## Yii2

Yii has a very visible application object:

```php
Yii::$app
```

Examples in your Yii project:

- `Yii::$app->db`
- `Yii::$app->user`
- `Yii::$app->request`
- `Yii::$app->restaurantInfo`

This is a very important Yii concept.

## Laravel

Laravel uses:

- service container
- facades
- helper functions

Examples:

- `request()`
- `view()`
- `redirect()`
- `Route::...`
- `Schema::...`

Laravel has a container too, but it feels less like one single central object compared to Yii's `Yii::$app`.

## Easy sentence for presentation

Yii makes framework services very visible through `Yii::$app`, while Laravel spreads service access through helpers, facades, dependency injection, and the service container.

---

## 17. CRUD difference in your actual projects

## Yii2 CRUD

Your Yii project has classic CRUD modules:

- Todo
- Menu
- Booking

Yii CRUD in your project includes:

- controller actions
- model rules
- `_form.php`
- `create.php`
- `update.php`
- `index.php`
- `view.php`
- GridView
- DetailView

This is very structured and very good for learning.

## Laravel CRUD

Your Laravel project is more custom-made.

It has:

- public pages in `PageController`
- admin pages in `AdminController`
- Blade views
- forms posted to named URLs

It works, but it is less "generated CRUD" and more "manual workflow CRUD".

## Easy sentence for presentation

Yii gives a more standardized CRUD structure out of the box, while Laravel in this project uses a more handcrafted route-controller-view approach.

---

## 18. Development flow in Laravel

If you want to develop the Laravel version, the usual flow is:

### 1. Create or update route

File:

- `routes/web.php`

### 2. Create or update controller method

File:

- `app/Http/Controllers/...`

### 3. Create or update model

File:

- `app/Models/...`

### 4. Create or update Blade view

File:

- `resources/views/...`

### 5. Run migration if database changes

Command example:

```powershell
php artisan migrate
```

### 6. Run dev server

Command example:

```powershell
php artisan serve
```

## Common Laravel commands

Create controller:

```powershell
php artisan make:controller MenuController
```

Create model:

```powershell
php artisan make:model Menu
```

Create migration:

```powershell
php artisan make:migration create_menus_table
```

Create model + migration + controller:

```powershell
php artisan make:model Menu -mcr
```

---

## 19. Development flow in Yii2

If you want to develop the Yii2 version, the usual flow is:

### 1. Create or update migration

File:

- `migrations/...`

Command:

```powershell
php yii migrate
```

### 2. Create model

Either manually or with Gii.

### 3. Create controller

Either manually or with Gii.

### 4. Create views

Usually:

- `_form.php`
- `index.php`
- `view.php`
- `create.php`
- `update.php`

### 5. Update config if needed

Files:

- `config/web.php`
- `config/db.php`

### 6. Open in browser

Often through local server / Laragon web root.

## Common Yii commands

Run migration:

```powershell
C:\laragon\bin\php\php-8.4.16-nts-Win32-vs17-x64\php.exe yii migrate
```

Open Gii:

```text
/gii
```

## Best Yii shortcut for beginners

Use **Gii** to create:

- model
- CRUD

This is one of Yii's biggest learning advantages.

---

## 20. How to explain both frameworks to your supervisor

You can say something like this:

> I implemented the restaurant system in both Laravel and Yii2 to compare framework architecture and development style. Both frameworks use MVC and support models, controllers, views, routing, migrations, and database CRUD. Laravel gave me a more explicit route-controller-Blade flow, while Yii2 gave me a more structured CRUD workflow with built-in widgets like GridView, DetailView, ActiveForm, and the Gii generator. Laravel felt more flexible and expressive for custom page flows, while Yii2 felt faster for admin-style CRUD development.

That is a strong presentation answer.

---

## 21. Best comparison table for presentation

| Topic | Laravel | Yii2 |
|---|---|---|
| Entry style | Route-driven | Controller/action-driven |
| Routes | Defined clearly in `routes/web.php` | Often based on controller + URL rules |
| Controller methods | Normal method names | `actionXxx()` methods |
| ORM | Eloquent | Active Record |
| Validation | Often in controller/request | Usually in model `rules()` |
| View system | Blade | PHP views |
| CRUD support | More manual by default | Strong built-in CRUD style |
| Form system | Plain HTML + Blade + CSRF | `ActiveForm` tied to model |
| Built-in widgets | Less built-in for admin tables | `GridView`, `DetailView`, etc. |
| Code generator | Artisan generates classes | Gii generates model + CRUD UI |
| Config style | `.env` + config files | PHP config arrays |
| Service access | helpers, facades, container | `Yii::$app` |

---

## 22. Which framework is easier?

This depends on the task.

## Laravel is often easier when:

- building custom pages
- writing routes clearly
- explaining simple controller flow
- using modern ecosystem tools

## Yii2 is often easier when:

- building admin panels
- making CRUD quickly
- using widgets
- generating code with Gii

## Best answer

Do not say one is absolutely better.

Say:

> Laravel is easier for flexible and expressive development flow, while Yii2 is easier for fast CRUD-based business application development.

That sounds balanced and professional.

---

## 23. How to learn both without getting confused

The best method is:

### Compare the same feature in both frameworks

For example:

#### Booking create flow

Laravel:

- route in `routes/web.php`
- form in Blade
- validation in controller
- `Booking::create()`
- redirect with session message

Yii2:

- route via controller/action
- form in `_form.php`
- validation in model
- `$model->load()` and `$model->save()`
- redirect to view/index

This is the best way to learn:

same business feature, two framework implementations

---

## 24. Your strongest learning examples in this repo

If you want to revise fast, study these pairs:

### Home page

- Laravel: [home.blade.php](c:\laragon\www\yii2-todo\RestaurantTask2\resources\views\pages\home.blade.php)
- Yii2: [site/index.php](c:\laragon\www\yii2-todo\views\site\index.php)

### Layout

- Laravel: [app.blade.php](c:\laragon\www\yii2-todo\RestaurantTask2\resources\views\layouts\app.blade.php)
- Yii2: [main.php](c:\laragon\www\yii2-todo\views\layouts\main.php)

### Booking model

- Laravel: [Booking.php](c:\laragon\www\yii2-todo\RestaurantTask2\app\Models\Booking.php)
- Yii2: [Booking.php](c:\laragon\www\yii2-todo\models\Booking.php)

### Booking table migration

- Laravel: [create_bookings_table.php](c:\laragon\www\yii2-todo\RestaurantTask2\database\migrations\2026_03_11_013501_create_bookings_table.php)
- Yii2: [m260318_044841_create_bookings_table.php](c:\laragon\www\yii2-todo\migrations\m260318_044841_create_bookings_table.php)

### Controller logic

- Laravel: [PageController.php](c:\laragon\www\yii2-todo\RestaurantTask2\app\Http\Controllers\PageController.php)
- Yii2: [SiteController.php](c:\laragon\www\yii2-todo\controllers\SiteController.php)

---

## 25. What to say if your supervisor asks "why did you build both?"

You can answer:

> I built both versions to understand not only the final application, but also how different PHP frameworks solve the same problems. By comparing routing, models, validation, views, CRUD structure, and database handling in both frameworks, I learned which framework is more suitable for rapid CRUD development and which one is better for custom route-driven development.

That is a very strong academic/professional answer.

---

## 26. Final presentation-ready conclusion

You can use this as your final summary:

> Laravel and Yii2 both support MVC web development, database interaction, validation, routing, and templating. In this restaurant project, Laravel uses explicit routes, Blade templates, and Eloquent models, which makes the code expressive and easy to customize. Yii2 uses controller-action routing, Active Record models, Gii code generation, and built-in widgets like GridView and ActiveForm, which makes it very efficient for structured CRUD applications. Working on both versions helped me understand not just how to build the system, but also how framework design affects development workflow.

---

## 27. My advice to you

Before presenting, memorize these 5 key differences:

1. Laravel routes are explicit in `routes/web.php`, Yii routes are more controller/action style.
2. Laravel uses Blade, Yii uses PHP views and widgets.
3. Laravel uses Eloquent with `$fillable`, Yii uses Active Record with `rules()`.
4. Laravel validates often in controllers, Yii validates often in models.
5. Yii is stronger out of the box for CRUD/admin patterns, Laravel is more flexible for custom app flow.

If you can explain those 5 calmly, you already understand the core difference.

---

## 28. If you want a next study file

I can also create one more Markdown file for you:

- a **presentation script**
- or a **Q&A cheat sheet** with possible supervisor questions and sample answers

