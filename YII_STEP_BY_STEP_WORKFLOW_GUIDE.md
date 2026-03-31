# Yii2 Step-by-Step Workflow Guide

This file is written for you as a beginner.

Goal of this guide:

- explain Yii2 in a practical way
- show the workflow page by page
- teach you what to do first when building something new
- make Yii feel less confusing than before

This guide is based on **your current Yii restaurant project**, not theory only.

---

## 1. First, what is Yii actually doing?

When you open a page in Yii, the flow is usually:

1. browser requests a URL
2. Yii matches that URL to a controller action
3. controller prepares data
4. controller sends data to a view
5. view renders HTML
6. layout wraps the page
7. browser shows the result

That is the main idea.

If you remember only one thing, remember this:

> URL -> Controller -> Model -> View -> Layout -> Browser

---

## 2. The most important folders in your project

### `web/`

This is the public entry point.

Important file:

- [index.php](c:\laragon\www\yii2-todo\web\index.php)

This file starts the Yii application.

### `config/`

This contains app configuration.

Important files:

- [web.php](c:\laragon\www\yii2-todo\config\web.php)
- [db.php](c:\laragon\www\yii2-todo\config\db.php)
- [params.php](c:\laragon\www\yii2-todo\config\params.php)

### `controllers/`

This contains page logic.

Examples:

- [SiteController.php](c:\laragon\www\yii2-todo\controllers\SiteController.php)
- [MenuController.php](c:\laragon\www\yii2-todo\controllers\MenuController.php)
- [BookingController.php](c:\laragon\www\yii2-todo\controllers\BookingController.php)

### `models/`

This contains data rules and database logic.

Examples:

- [Menu.php](c:\laragon\www\yii2-todo\models\Menu.php)
- [Booking.php](c:\laragon\www\yii2-todo\models\Booking.php)
- [ContactForm.php](c:\laragon\www\yii2-todo\models\ContactForm.php)

### `views/`

This contains page templates.

Examples:

- [views/site/index.php](c:\laragon\www\yii2-todo\views\site\index.php)
- [views/site/cart.php](c:\laragon\www\yii2-todo\views\site\cart.php)
- [views/menu/index.php](c:\laragon\www\yii2-todo\views\menu\index.php)

### `views/layouts/`

This contains the outer shell of the website.

Important file:

- [main.php](c:\laragon\www\yii2-todo\views\layouts\main.php)

### `assets/`

This contains asset bundles.

Important file:

- [YummyAsset.php](c:\laragon\www\yii2-todo\assets\YummyAsset.php)

### `migrations/`

This contains database structure changes.

Examples:

- bookings table migration
- menus table migration
- todo table migration

---

## 3. How to understand one page in Yii

Let us use the home page first.

### URL

Home page is controlled by:

- [SiteController.php](c:\laragon\www\yii2-todo\controllers\SiteController.php#L65)

Method:

```php
actionIndex()
```

### What it does

This method:

- loads menu data
- loads booking counts
- groups menu by category
- sends data into the view

### View

The page is shown by:

- [views/site/index.php](c:\laragon\www\yii2-todo\views\site\index.php)

### Layout

Then it is wrapped by:

- [views/layouts/main.php](c:\laragon\www\yii2-todo\views\layouts\main.php)

So page understanding looks like:

1. open controller
2. find action
3. find render() call
4. open view file
5. check layout

This is the same method you should use for every page.

---

## 4. How to understand any existing page

Use this exact checklist every time:

### Step 1. Identify the URL

Example:

- `/site/cart`
- `/menu/index`
- `/booking/create`

### Step 2. Find the controller

Usually:

- `site/...` -> `SiteController`
- `menu/...` -> `MenuController`
- `booking/...` -> `BookingController`

### Step 3. Find the action

Example:

- `/site/cart` -> `actionCart()`
- `/menu/index` -> `actionIndex()`
- `/booking/create` -> `actionCreate()`

### Step 4. Find the view

Look for:

```php
return $this->render('view-name', [...]);
```

Then open the view file.

### Step 5. Check the model

If the page loads or saves data, open the related model too.

Example:

- menu page -> [Menu.php](c:\laragon\www\yii2-todo\models\Menu.php)
- booking page -> [Booking.php](c:\laragon\www\yii2-todo\models\Booking.php)

This is the best habit for learning Yii.

---

## 5. What to do if you want to add a simple new page

Let us say you want to add a new page called:

`Special Offers`

## Step 1. Add an action in controller

If it is a general website page, add it in:

- [SiteController.php](c:\laragon\www\yii2-todo\controllers\SiteController.php)

Example:

```php
public function actionOffers()
{
    return $this->render('offers');
}
```

## Step 2. Create the view file

Create:

- `views/site/offers.php`

Example:

```php
<?php
/** @var yii\web\View $this */

$this->title = 'Special Offers';
?>

<h1>Special Offers</h1>
<p>This is my new page.</p>
```

## Step 3. Open the URL

Open:

```text
/site/offers
```

If pretty URLs work, maybe:

```text
/offers
```

depending on routing rules.

## Step 4. Add nav link if needed

Open:

- [main.php](c:\laragon\www\yii2-todo\views\layouts\main.php)

Add a link in the nav.

That is the most basic page workflow in Yii.

---

## 6. What to do if you want to add a new database-backed module

Let us say you want to add:

`Customer`

This is different from a simple static page.

For a database-backed module, do this:

### Step 1. Create migration

Create a migration file in:

- `migrations/`

Example structure:

```php
class m260330_000001_create_customers_table extends Migration
{
    public function up()
    {
        $this->createTable('customers', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }
}
```

### Step 2. Run migration

Command:

```powershell
C:\laragon\bin\php\php-8.4.16-nts-Win32-vs17-x64\php.exe yii migrate
```

### Step 3. Create model

Create:

- `models/Customer.php`

This model should:

- extend ActiveRecord
- point to `customers` table
- define rules

### Step 4. Create controller

Create:

- `controllers/CustomerController.php`

### Step 5. Create views

Usually:

- `views/customer/index.php`
- `views/customer/view.php`
- `views/customer/create.php`
- `views/customer/update.php`
- `views/customer/_form.php`

### Step 6. Add links if needed

Update navigation or homepage.

This is the normal CRUD workflow.

---

## 7. The easiest order to build things in Yii

If you want to build something new, use this order:

1. database table first
2. model second
3. controller third
4. views fourth
5. navigation/layout fifth
6. testing last

This order works very well in Yii.

Why?

Because:

- model depends on table structure
- controller depends on model
- view depends on controller data

---

## 8. What to do first when you are confused

If you feel lost, ask this question:

> Am I building a page only, or a page with database?

### If page only

Start with:

- controller action
- view file

### If page with database

Start with:

- migration
- model
- controller
- view

This one question will reduce confusion a lot.

---

## 9. How forms work in Yii

Forms in Yii usually use:

- `ActiveForm`

Example files:

- [views/booking/_form.php](c:\laragon\www\yii2-todo\views\booking\_form.php)
- [views/menu/_form.php](c:\laragon\www\yii2-todo\views\menu\_form.php)
- [views/site/checkout.php](c:\laragon\www\yii2-todo\views\site\checkout.php)

## Form workflow

### Step 1. Form displays fields

Example:

```php
<?= $form->field($model, 'name')->textInput() ?>
```

### Step 2. User submits form

### Step 3. Controller loads POST data

Example:

```php
$model->load(Yii::$app->request->post())
```

### Step 4. Model validates data

Using `rules()`

### Step 5. If valid, save to database

Example:

```php
$model->save()
```

So the full idea is:

> Form -> Controller load() -> Model rules() -> save()

---

## 10. How file upload works in Yii

You already now have image upload in menu.

Look at:

- [MenuController.php](c:\laragon\www\yii2-todo\controllers\MenuController.php#L80)
- [Menu.php](c:\laragon\www\yii2-todo\models\Menu.php#L19)
- [menu/_form.php](c:\laragon\www\yii2-todo\views\menu\_form.php#L13)

## Upload workflow

### Step 1. Add file property in model

Example:

```php
public $imageFile;
```

### Step 2. Add validation rule

Example:

```php
[['imageFile'], 'file', 'extensions' => ['png', 'jpg']]
```

### Step 3. Make form multipart

Example:

```php
'options' => ['enctype' => 'multipart/form-data']
```

### Step 4. Use file input

Example:

```php
<?= $form->field($model, 'imageFile')->fileInput() ?>
```

### Step 5. In controller, get uploaded file

Example:

```php
$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
```

### Step 6. Save file physically

Example:

```php
$model->imageFile->saveAs(...)
```

### Step 7. Save filename in DB

Example:

```php
$model->image = $fileName;
```

This is the standard upload pattern in Yii.

---

## 11. How database save works in Yii

Use booking as example.

Files:

- [BookingController.php](c:\laragon\www\yii2-todo\controllers\BookingController.php)
- [Booking.php](c:\laragon\www\yii2-todo\models\Booking.php)

## Save workflow

### Step 1. Create model object

```php
$model = new Booking();
```

### Step 2. Load form data

```php
$model->load(Yii::$app->request->post())
```

### Step 3. Validate with rules

This happens during:

```php
$model->save()
```

### Step 4. Save through Active Record

Yii writes to the `bookings` table.

This uses:

- `config/db.php`
- `Yii::$app->db`
- PDO internally

---

## 12. How to add a new menu category

Now your menu categories come from:

- [Menu.php](c:\laragon\www\yii2-todo\models\Menu.php)

Method:

```php
categoryOptions()
```

If you want to add new category like `dessert`, do this:

### Step 1. Open model

- [Menu.php](c:\laragon\www\yii2-todo\models\Menu.php)

### Step 2. Update category options

Example:

```php
'dessert' => 'Dessert',
```

### Step 3. If homepage tabs depend on categories, update view too

- [views/site/index.php](c:\laragon\www\yii2-todo\views\site\index.php)

Because right now category tabs are manually listed there too.

This is important:

Sometimes one feature exists in more than one file.

In Yii, always search the keyword in project before editing.

---

## 13. What to do if you want to add another frontend page

Example: `Chef Team` page

### First

Decide:

- Is it static?
- Or does it need database?

### If static

1. add action in `SiteController`
2. create view in `views/site`
3. add nav link

### If dynamic

1. create migration if needed
2. create model
3. load data in controller
4. render view

---

## 14. What to do if you want to add another admin page

Example: `Customer Feedback Admin`

### Recommended flow

1. migration
2. model
3. controller
4. CRUD views
5. add link in navbar or admin menu

If it is basic CRUD, Yii is actually very strong for this.

This is where Gii helps a lot.

---

## 15. How Gii fits into workflow

Gii is useful when you want to quickly create:

- model
- CRUD

Use Gii after table exists.

Best order with Gii:

1. make database table
2. open Gii
3. generate model
4. generate CRUD
5. clean up generated code

Generated code is just starting point.
You still need to:

- improve form fields
- remove bad fields
- improve labels
- add upload logic
- add UI styling

You already experienced this in `Booking` and `Menu`.

---

## 16. Why Yii feels more complex than Laravel

You said Laravel feels easier.
That makes sense.

Laravel often feels easier because:

- routes are very explicit
- Blade is easy to read
- controller flow is very direct

Yii feels harder at first because:

- more configuration
- more conventions
- more widgets/components
- routes may feel less obvious

But Yii becomes easier once you use the same pattern repeatedly:

- controller action
- model rules
- view file
- render

The trick is not to learn everything.
The trick is to repeat the same pattern many times.

---

## 17. Best debugging method in Yii

When something breaks, use this order:

### 1. Check the error message

Yii errors are often very helpful.

### 2. Check controller

Is action running?

### 3. Check model rules

Is validation blocking save?

### 4. Check form field names

Do they match model attributes?

### 5. Check database table

Do columns match model expectations?

### 6. Check logs

Look in:

- `runtime/logs/app.log`

This is the normal Yii debugging flow.

---

## 18. Real workflow examples from your project

## Example A: Add new menu item

1. Open `Manage Menu`
2. Click `Create Menu`
3. Fill form in [menu/_form.php](c:\laragon\www\yii2-todo\views\menu\_form.php)
4. Submit
5. `MenuController::actionCreate()` runs
6. `Menu` model validates
7. image file is uploaded
8. filename saved into database
9. redirect to menu detail page

## Example B: Customer order flow

1. User opens homepage
2. Clicks `Add to Cart`
3. JavaScript stores item in `localStorage`
4. User opens cart page
5. User opens checkout
6. Fills booking details
7. `SiteController::actionCheckout()` saves confirmed booking
8. User goes to order confirmation page

## Example C: Booking CRUD

1. Admin opens booking index
2. Yii loads all bookings
3. `GridView` shows rows
4. Admin clicks one row
5. `DetailView` shows one record

This is how you should explain the app to yourself:

not as random files, but as flows.

---

## 19. If you want to add another page, what to do first?

This is your direct answer.

### Ask this first:

> Is this page static or database-driven?

### If static:

1. create controller action
2. create view
3. test URL
4. add nav link

### If database-driven:

1. design table
2. create migration
3. run migration
4. create model
5. create controller action(s)
6. create view(s)
7. connect layout/nav
8. test create/read/update flow

That is the right starting point.

---

## 20. Recommended way for you to learn this project

Do not jump randomly.

Study in this order:

### Round 1: frontend public flow

1. [views/layouts/main.php](c:\laragon\www\yii2-todo\views\layouts\main.php)
2. [controllers/SiteController.php](c:\laragon\www\yii2-todo\controllers\SiteController.php)
3. [views/site/index.php](c:\laragon\www\yii2-todo\views\site\index.php)
4. [views/site/cart.php](c:\laragon\www\yii2-todo\views\site\cart.php)
5. [views/site/checkout.php](c:\laragon\www\yii2-todo\views\site\checkout.php)
6. [views/site/order-confirmed.php](c:\laragon\www\yii2-todo\views\site\order-confirmed.php)

### Round 2: menu admin flow

1. [controllers/MenuController.php](c:\laragon\www\yii2-todo\controllers\MenuController.php)
2. [models/Menu.php](c:\laragon\www\yii2-todo\models\Menu.php)
3. [views/menu/_form.php](c:\laragon\www\yii2-todo\views\menu\_form.php)
4. [views/menu/index.php](c:\laragon\www\yii2-todo\views\menu\index.php)
5. [views/menu/view.php](c:\laragon\www\yii2-todo\views\menu\view.php)

### Round 3: booking flow

1. [controllers/BookingController.php](c:\laragon\www\yii2-todo\controllers\BookingController.php)
2. [models/Booking.php](c:\laragon\www\yii2-todo\models\Booking.php)
3. [views/booking/_form.php](c:\laragon\www\yii2-todo\views\booking\_form.php)
4. [views/booking/index.php](c:\laragon\www\yii2-todo\views\booking\index.php)
5. [views/booking/view.php](c:\laragon\www\yii2-todo\views\booking\view.php)

This learning order will help a lot.

---

## 21. Very important mindset

Do not think:

"Yii is too big, I need to understand all files."

Think like this:

"I only need to understand one workflow at a time."

That is the correct way.

Example:

Today:

- understand checkout flow only

Tomorrow:

- understand menu create/update only

Next:

- understand booking admin only

That is how Yii becomes manageable.

---

## 22. Final quick cheat sheet

### Add static page

1. controller action
2. view file
3. nav link

### Add DB feature

1. migration
2. model
3. controller
4. views
5. test

### Fix save issue

1. check form
2. check controller load/save
3. check model rules
4. check database column type

### Add upload

1. model property
2. file rule
3. multipart form
4. upload logic in controller
5. save file name to DB

### Understand page

1. find URL
2. find controller
3. find action
4. find view
5. find model

---

## 23. Best next help I can give you

If you want, I can create one more Markdown file after this:

- `YII_PAGE_BY_PAGE_PROJECT_WALKTHROUGH.md`

That one would explain your actual project one page at a time:

- Home
- Cart
- Checkout
- Order Confirmed
- Menu Admin
- Booking Admin

like a classroom lesson.

