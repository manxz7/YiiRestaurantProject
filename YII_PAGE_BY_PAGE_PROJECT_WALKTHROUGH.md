# Yii2 Restaurant Project Walkthrough

This file explains your current Yii2 restaurant project in a beginner-friendly way.

The goal is simple:

- understand how this Yii2 project works page by page
- understand the workflow from browser request to database save
- know what files to touch when adding a new feature
- be able to compare this Yii2 project with your Laravel restaurant project

---

## 1. Big Picture First

Your Yii2 project is now a **restaurant web application**, not a to-do list application.

It includes:

- public website pages
- menu display
- cart page
- checkout page
- order confirmation page
- menu management pages
- booking management pages

So when you present this project, you can say:

> "I recreated the same restaurant system in Yii2 so I could compare the Yii2 workflow with the Laravel workflow."

---

## 2. The Main Yii2 Flow

When a user opens a page in Yii2, the normal flow is:

1. Browser requests a URL
2. Yii reads the route
3. Yii chooses a controller and action
4. The controller may talk to a model
5. The model may talk to the database
6. The controller sends data to a view
7. The view generates HTML
8. The layout wraps the page with header and footer
9. The browser displays the final page

Short version:

`URL -> Controller -> Model -> View -> Layout -> Browser`

This is the most important Yii idea to remember.

Laravel is also similar, but Yii often feels more explicit because:

- controller actions are very visible
- model validation rules are strongly centered in the model
- CRUD pages often come from Gii structure
- widgets like `GridView` and `DetailView` are used a lot

---

## 3. Important Folders In Your Project

These are the folders you should understand first.

### `controllers/`

This contains the logic for handling requests.

Important files in your project:

- [SiteController.php](/c:/laragon/www/yii2-todo/controllers/SiteController.php)
- [MenuController.php](/c:/laragon/www/yii2-todo/controllers/MenuController.php)
- [BookingController.php](/c:/laragon/www/yii2-todo/controllers/BookingController.php)

What they do:

- `SiteController` handles public pages like home, cart, checkout, contact
- `MenuController` handles menu CRUD pages
- `BookingController` handles booking CRUD pages

### `models/`

This contains the data logic.

Important files:

- [Menu.php](/c:/laragon/www/yii2-todo/models/Menu.php)
- [Booking.php](/c:/laragon/www/yii2-todo/models/Booking.php)
- [ContactForm.php](/c:/laragon/www/yii2-todo/models/ContactForm.php)

What they do:

- define table names
- define validation rules
- define labels
- interact with database using Active Record

### `views/`

This contains the page templates.

Important folders:

- [views/site](/c:/laragon/www/yii2-todo/views/site)
- [views/menu](/c:/laragon/www/yii2-todo/views/menu)
- [views/booking](/c:/laragon/www/yii2-todo/views/booking)
- [views/layouts](/c:/laragon/www/yii2-todo/views/layouts)

What they do:

- show HTML to the user
- display model data
- render forms and tables

### `config/`

This contains application settings.

Important files:

- [web.php](/c:/laragon/www/yii2-todo/config/web.php)
- [db.php](/c:/laragon/www/yii2-todo/config/db.php)

What they do:

- register components
- configure URL behavior
- configure database connection
- enable Gii and Debug in development

### `web/`

This is the public entry point.

Important file:

- [index.php](/c:/laragon/www/yii2-todo/web/index.php)

This is the first PHP file hit by the browser.

---

## 4. Your Real Project Workflow

Your project has two main sides.

### Public user flow

This is what restaurant customers use:

1. Home page
2. Menu section
3. Add to cart
4. Cart page
5. Checkout page
6. Order confirmed page

### Admin or management flow

This is what you use to manage data:

1. Manage Menu
2. Create menu item
3. Update menu item
4. View menu item
5. Manage bookings
6. View booking
7. Update booking
8. Delete booking if needed

This separation is very important for understanding the app.

---

## 5. Page By Page Walkthrough

Now let us walk through the actual pages in your Yii2 restaurant project.

---

## 6. Page 1: Home Page

File route:

- URL: `/site/index` or `/`
- Controller: [SiteController.php](/c:/laragon/www/yii2-todo/controllers/SiteController.php)
- Action: `actionIndex()`
- View: [views/site/index.php](/c:/laragon/www/yii2-todo/views/site/index.php)
- Layout: [views/layouts/main.php](/c:/laragon/www/yii2-todo/views/layouts/main.php)

### What happens here

When the user opens the home page:

1. Yii routes the request to `SiteController::actionIndex()`
2. The action loads menu data from the `Menu` model
3. The action loads booking counts from the `Booking` model
4. The action groups menu items by category
5. The action sends the data to the `index` view
6. The view displays the hero section, about section, menu tabs, and other sections
7. The layout adds header, footer, and cart button

### Why this page is important

This page teaches you the basic Yii pattern:

- query data in controller
- pass array of data into view
- loop over data in view

### Example concept

In `actionIndex()`, you do things like:

- `Menu::find()->where(...)->all()`
- `Booking::find()->count()`

That means the controller is coordinating the page, while the model handles database access.

### Laravel comparison

In Laravel, this feels similar to:

- route
- controller method
- Eloquent query
- `return view(...)`

But in Yii, the route is often easier to guess from the controller/action name.

---

## 7. Page 2: Cart Page

File route:

- URL: `/site/cart`
- Controller: [SiteController.php](/c:/laragon/www/yii2-todo/controllers/SiteController.php)
- Action: `actionCart()`
- View: [views/site/cart.php](/c:/laragon/www/yii2-todo/views/site/cart.php)

### What happens here

1. User adds menu items from the home page
2. JavaScript stores those items in `localStorage`
3. User opens `/site/cart`
4. `actionCart()` simply renders the page
5. JavaScript reads cart data from `localStorage`
6. The cart page displays quantity, items, and total

### Important note

This page is mostly front-end driven.

That means:

- controller logic is minimal
- JavaScript does more work
- the cart is not yet stored in a separate database table

### What to learn from this page

Not every page needs heavy controller logic.

Sometimes Yii only needs to render a view, and the front end handles the rest.

---

## 8. Page 3: Checkout Page

File route:

- URL: `/site/checkout`
- Controller: [SiteController.php](/c:/laragon/www/yii2-todo/controllers/SiteController.php)
- Action: `actionCheckout()`
- View: [views/site/checkout.php](/c:/laragon/www/yii2-todo/views/site/checkout.php)
- Model used: [Booking.php](/c:/laragon/www/yii2-todo/models/Booking.php)

### What happens here

This is one of the most important pages in the whole project.

Step by step:

1. User opens checkout page
2. Controller creates a new `Booking` model
3. Controller sets default status to `confirmed`
4. Checkout form is shown
5. User fills in name, email, phone, date, time, people
6. User submits form
7. `actionCheckout()` loads POST data into the model
8. Hidden cart data is also read from the request
9. Cart summary is added into the booking `message`
10. Yii validates the model using rules in `Booking.php`
11. If valid, Active Record saves it into the `bookings` table
12. User is redirected to confirmation page

### This is the exact meaning of `$model->load()` and `$model->save()`

`$model->load(...)`

- takes user input from the form
- fills the model attributes

`$model->save()`

- validates the data
- if valid, inserts into database

This is one of the most important Yii shortcuts to understand.

### Why your earlier date error happened

Your database expected:

- date like `2026-03-30`
- time like `09:00:00`

But the form had values like:

- `2/4`
- `9`

So MySQL rejected the insert.

That is why we changed the form and model validation.

### Laravel comparison

This is similar to Laravel:

- create model instance
- fill request data
- validate
- save to database
- redirect

But in Yii, model validation is commonly placed directly inside the Active Record model.

---

## 9. Page 4: Order Confirmed Page

File route:

- URL: `/site/order-confirmed?id=...`
- Controller: [SiteController.php](/c:/laragon/www/yii2-todo/controllers/SiteController.php)
- Action: `actionOrderConfirmed($id)`
- View: [views/site/order-confirmed.php](/c:/laragon/www/yii2-todo/views/site/order-confirmed.php)

### What happens here

1. After checkout save succeeds, Yii redirects here
2. The booking ID is passed in the URL
3. Controller finds that booking using `Booking::findOne($id)`
4. If no record is found, Yii throws 404
5. If found, the booking is displayed in the confirmation page

### What to learn from this page

This teaches:

- how to pass an ID in the URL
- how to fetch one database record
- how to handle missing data safely with 404

This pattern is extremely common in Yii.

---

## 10. Page 5: Menu Management Index

File route:

- URL: `/menu/index`
- Controller: [MenuController.php](/c:/laragon/www/yii2-todo/controllers/MenuController.php)
- Action: `actionIndex()`
- View: [views/menu/index.php](/c:/laragon/www/yii2-todo/views/menu/index.php)

### What happens here

1. Controller creates an `ActiveDataProvider`
2. The provider uses `Menu::find()`
3. The view receives the data provider
4. The view shows the menu items in a Yii widget, usually `GridView`

### Why `ActiveDataProvider` matters

This is a Yii-style feature.

It helps with:

- table listing
- pagination
- sorting
- easy connection to `GridView`

### Laravel comparison

In Laravel, you might manually pass a paginated collection to Blade.

In Yii, `ActiveDataProvider` plus `GridView` is a common pair.

---

## 11. Page 6: Create Menu Page

File route:

- URL: `/menu/create`
- Controller: [MenuController.php](/c:/laragon/www/yii2-todo/controllers/MenuController.php)
- Action: `actionCreate()`
- View: [views/menu/create.php](/c:/laragon/www/yii2-todo/views/menu/create.php)
- Shared form: [views/menu/_form.php](/c:/laragon/www/yii2-todo/views/menu/_form.php)
- Model: [Menu.php](/c:/laragon/www/yii2-todo/models/Menu.php)

### What happens here

1. Controller creates a new `Menu` model
2. User opens the page
3. The shared `_form.php` file renders the form
4. User enters name, ingredients, price, category, availability
5. User uploads image
6. Controller reads form data into model
7. Controller reads uploaded file using `UploadedFile::getInstance(...)`
8. Model validates all fields
9. Controller stores image inside `web/yummy-red/img/menu/`
10. Controller saves image filename into database column `image`
11. Menu record is saved
12. User is redirected to detail page

### Why `_form.php` exists

Yii CRUD usually reuses the same form for:

- create page
- update page

So instead of duplicating HTML, Yii uses one partial form file.

This is normal and good practice.

---

## 12. Page 7: Update Menu Page

File route:

- URL: `/menu/update?id=...`
- Controller: [MenuController.php](/c:/laragon/www/yii2-todo/controllers/MenuController.php)
- Action: `actionUpdate($id)`
- View: [views/menu/update.php](/c:/laragon/www/yii2-todo/views/menu/update.php)
- Shared form: [views/menu/_form.php](/c:/laragon/www/yii2-todo/views/menu/_form.php)

### What happens here

1. Controller loads existing menu item using `findModel($id)`
2. Form is prefilled with current database values
3. User changes the fields
4. If user uploads a new image, controller saves new file
5. If user does not upload a new image, old image is kept
6. Controller saves updated record

### What to learn from this page

This teaches the update workflow:

- fetch old record
- load new POST data
- validate
- save changes

This is one of the most repeated CRUD patterns in Yii.

---

## 13. Page 8: View Menu Page

File route:

- URL: `/menu/view?id=...`
- Controller: [MenuController.php](/c:/laragon/www/yii2-todo/controllers/MenuController.php)
- Action: `actionView($id)`
- View: [views/menu/view.php](/c:/laragon/www/yii2-todo/views/menu/view.php)

### What happens here

1. Controller finds a single menu record
2. View shows full details of that record
3. Yii often uses `DetailView` widget here

### What to learn

This page teaches simple record display after fetching one model.

---

## 14. Page 9: Booking Management Index

File route:

- URL: `/booking/index`
- Controller: [BookingController.php](/c:/laragon/www/yii2-todo/controllers/BookingController.php)
- Action: `actionIndex()`
- View: [views/booking/index.php](/c:/laragon/www/yii2-todo/views/booking/index.php)

### What happens here

1. Controller creates `ActiveDataProvider`
2. Query uses `Booking::find()`
3. View displays all booking records

### Why this matters

This page is your back-office record listing.

It lets you inspect what was submitted from checkout.

---

## 15. Page 10: View and Update Booking

Routes:

- `/booking/view?id=...`
- `/booking/update?id=...`

Files:

- [views/booking/view.php](/c:/laragon/www/yii2-todo/views/booking/view.php)
- [views/booking/update.php](/c:/laragon/www/yii2-todo/views/booking/update.php)
- [views/booking/_form.php](/c:/laragon/www/yii2-todo/views/booking/_form.php)

### What happens here

This is the same CRUD pattern again:

1. find record by ID
2. display or edit it
3. validate with `Booking` model rules
4. save changes

Once you understand one CRUD module in Yii, the others become easier.

---

## 16. The Layout Workflow

The file [main.php](/c:/laragon/www/yii2-todo/views/layouts/main.php) is your global layout.

This means it wraps many pages automatically.

It contains:

- header
- navbar
- login/logout button
- cart floating button
- footer
- shared JS for cart count

### Important Yii idea

The controller usually renders a **view**, but Yii often places that inside a **layout**.

So:

- page content comes from `views/site/...` or `views/menu/...`
- shared structure comes from `views/layouts/main.php`

This is similar to Laravel Blade layouts.

---

## 17. How The Database Connects

Your database connection is configured in:

- [db.php](/c:/laragon/www/yii2-todo/config/db.php)

This file defines:

- MySQL host
- database name
- username
- password

Then [web.php](/c:/laragon/www/yii2-todo/config/web.php) registers it as the `db` component.

That means you can access it through:

`Yii::$app->db`

But usually you do not call raw SQL directly.

Instead, models like `Menu` and `Booking` use Active Record.

### Active Record idea

`Menu` represents the `menus` table.

`Booking` represents the `bookings` table.

So when you do:

`Menu::find()->all()`

Yii queries the `menus` table.

When you do:

`$booking->save()`

Yii inserts or updates the `bookings` table.

---

## 18. How Validation Works

Validation rules are inside the model.

Example:

- [Booking.php](/c:/laragon/www/yii2-todo/models/Booking.php)
- [Menu.php](/c:/laragon/www/yii2-todo/models/Menu.php)

This means:

- required fields are defined in the model
- email format is defined in the model
- date and time format are defined in the model
- category choices are defined in the model
- image upload validation is defined in the model

### Why this is powerful

The model becomes the central place for business rules.

That is why Yii can feel strict at first, but it becomes easier once you accept this pattern.

---

## 19. How To Understand Any Yii Page

Whenever you see a page and feel confused, use this order:

1. Check the URL
2. Identify the controller
3. Find the action method
4. See whether the action uses a model
5. Check what data is sent to the view
6. Open the view file
7. Check whether a shared `_form.php` is used
8. Check the layout if header/footer behavior matters

This is the safest beginner workflow.

If you skip straight into random files, Yii feels confusing.

---

## 20. If You Want To Add A New Static Page

Example: you want to add a page called `Chef`.

Do this in order:

1. Add action in controller
2. Create view file
3. Add nav link
4. Test route in browser

### Step 1: Add action

Inside [SiteController.php](/c:/laragon/www/yii2-todo/controllers/SiteController.php):

```php
public function actionChef()
{
    return $this->render('chef');
}
```

### Step 2: Create view

Create:

- [chef.php](/c:/laragon/www/yii2-todo/views/site/chef.php)

Example:

```php
<?php
use yii\helpers\Html;

$this->title = 'Chef';
?>

<div class="chef-page">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>This is the chef page.</p>
</div>
```

### Step 3: Add nav link

Edit:

- [main.php](/c:/laragon/www/yii2-todo/views/layouts/main.php)

Add a link to:

`/site/chef`

### Step 4: Test

Open:

`http://localhost/yii2-todo/web/site/chef`

or your pretty URL version.

This is the simplest Yii page workflow.

---

## 21. If You Want To Add A New Database Feature

Example: you want to add `Testimonials`.

Do this in order:

1. Create database table
2. Create model
3. Create controller
4. Create views
5. Add nav links
6. Test create, list, view, update, delete

### Step 1: Create table

You can use:

- migration
- phpMyAdmin

Best practice for real development is migration.

### Step 2: Create model

You can use Gii or write manually.

Model responsibilities:

- table name
- rules
- labels

### Step 3: Create controller

Use Gii CRUD generator or write manually.

Controller responsibilities:

- list records
- create record
- update record
- delete record
- find model by ID

### Step 4: Create views

Usually Yii CRUD gives:

- `index.php`
- `view.php`
- `create.php`
- `update.php`
- `_form.php`

### Step 5: Add links

Add access path from layout or homepage.

### Step 6: Test everything

Always test:

- validation
- save
- update
- delete
- image upload if any

This is the standard Yii development workflow.

---

## 22. How Gii Helps You

Gii is Yii's code generator.

In your project, Gii is enabled in development through:

- [web.php](/c:/laragon/www/yii2-todo/config/web.php)

Usually you open:

`http://localhost/yii2-todo/web/index.php?r=gii`

or pretty URL version depending on setup.

### What Gii can generate

- model
- CRUD
- controller
- form
- module

### Practical use in your project

You can use Gii to generate:

- a model from an existing table
- CRUD pages for that model

Then you customize the generated files.

That is exactly how many Yii projects are built.

### Important mindset

Gii does not finish your app.

Gii gives you a strong starting structure.

Then you:

- improve validation
- improve UI
- add upload logic
- add business rules

---

## 23. Why Yii Feels Harder Than Laravel At First

This is normal.

Many beginners feel Laravel is easier because:

- the learning materials are very beginner-friendly
- Blade feels simple
- routing is easy to read
- controller plus request flow feels softer

Yii feels harder because:

- it is more structured
- it uses many framework-specific classes
- Gii-generated code can feel formal
- widgets like `GridView` and `ActiveDataProvider` are new concepts

But once you understand the repeated Yii pattern, it becomes more predictable.

The repeated pattern is:

`Model -> Controller -> View -> CRUD -> Gii -> Widget`

Yii often becomes easier after you understand its repetition.

---

## 24. Fast Mental Model For Yii

If you want one simple memory trick, use this:

### For public pages

`SiteController action -> view -> layout`

### For database pages

`table -> model -> controller -> _form -> index/view/create/update`

### For saving data

`form submit -> load() -> validate() -> save() -> redirect()`

If you remember these three lines, Yii becomes much less scary.

---

## 25. Page-Building Checklist

When adding a new page, use this checklist.

### Static page checklist

1. decide the URL
2. add controller action
3. create view file
4. set page title
5. add link in layout if needed
6. test in browser

### Database feature checklist

1. create table
2. create model
3. add validation rules
4. create controller
5. create index/view/create/update pages
6. create or reuse `_form.php`
7. test saving
8. test invalid input
9. test update
10. test delete

---

## 26. How To Explain This To Your Supervisor

You can say it like this:

> "In Yii2, each page usually follows a clear controller-model-view structure. For this restaurant project, public customer pages are handled in `SiteController`, while database management pages like menu and booking use CRUD controllers generated from Yii patterns. The models contain validation and database rules, the controllers coordinate data flow, and the views render the interface. This helped me compare Yii2 with Laravel using the same restaurant system."

Shorter version:

> "Laravel felt easier first, but Yii2 helped me understand framework structure more clearly because the workflow is very explicit: route, controller, model, validation, view, and CRUD widgets."

---

## 27. What You Should Study Next

To become comfortable, study in this order:

1. [SiteController.php](/c:/laragon/www/yii2-todo/controllers/SiteController.php)
2. [views/site/index.php](/c:/laragon/www/yii2-todo/views/site/index.php)
3. [Booking.php](/c:/laragon/www/yii2-todo/models/Booking.php)
4. [Menu.php](/c:/laragon/www/yii2-todo/models/Menu.php)
5. [MenuController.php](/c:/laragon/www/yii2-todo/controllers/MenuController.php)
6. [BookingController.php](/c:/laragon/www/yii2-todo/controllers/BookingController.php)
7. [main.php](/c:/laragon/www/yii2-todo/views/layouts/main.php)
8. [web.php](/c:/laragon/www/yii2-todo/config/web.php)
9. [db.php](/c:/laragon/www/yii2-todo/config/db.php)

That order follows the real app workflow from browser page to data layer.

---

## 28. Final Summary

Your Yii2 restaurant project works like this:

- `SiteController` handles public pages
- `MenuController` handles menu management
- `BookingController` handles booking management
- `Menu` and `Booking` models talk to MySQL using Active Record
- views show the HTML
- layout wraps all pages
- `config/db.php` connects to MySQL
- `config/web.php` registers the application components

If you feel lost, do not try to understand everything at once.

Always ask these 4 questions:

1. What URL am I on?
2. Which controller action handles it?
3. Which model does it use?
4. Which view renders it?

If you answer those 4 questions, you can usually understand the page.

---

## 29. Best Next Step

The best next learning exercise is this:

Create one small new feature by yourself, for example:

- testimonials page
- chef page
- categories management
- order history page

That will force you to practice the Yii workflow instead of only reading theory.

If you want, the next thing I can do is create another Markdown file called:

`YII_PRACTICE_EXERCISES_FOR_THIS_PROJECT.md`

That file can give you beginner exercises with answers based on your exact restaurant project.
