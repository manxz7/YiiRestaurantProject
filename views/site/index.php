<?php

/** @var yii\web\View $this */
/** @var app\models\Menu[] $featuredMenus */
/** @var array<string, app\models\Menu[]> $menusByCategory */
/** @var int $bookingCount */
/** @var int $availableMenuCount */
/** @var int $confirmedBookingCount */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Home';
$this->params['bodyClass'] = 'index-page';

$fallbackImages = [
    'menu-item-1.png',
    'menu-item-2.png',
    'menu-item-3.png',
    'menu-item-4.png',
    'menu-item-5.png',
    'menu-item-6.png',
];

$categoryTitles = [
    'starters' => 'Starters',
    'breakfast' => 'Breakfast',
    'lunch' => 'Lunch',
    'dinner' => 'Dinner',
];
?>
<section id="hero" class="hero section light-background">
    <div class="container">
        <div class="row gy-4 justify-content-center justify-content-lg-between">
            <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center">
                <h1 data-aos="fade-up">Enjoy Fresh Food<br>Made With Heart</h1>
                <p data-aos="fade-up" data-aos-delay="100">From comforting Malaysian favorites to crowd-pleasing grilled specials, Yummy Red brings vibrant flavors, warm service, and easy table reservations together in one place.</p>
                <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                    <a href="#menu" class="btn-get-started">Order Food</a>
                    <a href="<?= Html::encode(Url::to(['/site/cart'])) ?>" class="btn-watch-video d-flex align-items-center"><i class="bi bi-cart3"></i><span>Open Cart</span></a>
                </div>
            </div>
            <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                <img src="<?= Html::encode(Url::to('@web/yummy-red/img/hero-img.png')) ?>" class="img-fluid animated" alt="Hero dish">
            </div>
        </div>
    </div>
</section>

<section id="about" class="about section">
    <div class="container section-title" data-aos="fade-up">
        <h2>About Us</h2>
        <p><span>Learn More</span> <span class="description-title">About Yummy Red</span></p>
    </div>

    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
                <img src="<?= Html::encode(Url::to('@web/yummy-red/img/about.jpg')) ?>" class="img-fluid mb-4" alt="Restaurant interior">
                <div class="book-a-table">
                    <h3>Book a Table</h3>
                    <p><?= Html::encode(Yii::$app->restaurantInfo->phone) ?></p>
                </div>
            </div>
            <div class="col-lg-5" data-aos="fade-up" data-aos-delay="250">
                <div class="content ps-0 ps-lg-5">
                    <p class="fst-italic">
                        Yummy Red is a lively city restaurant where comforting classics, smoky grilled dishes, and fresh house-made sauces come together for lunch, dinner, and casual celebrations.
                    </p>
                    <ul>
                        <li><i class="bi bi-check-circle-fill"></i> <span>Signature menu of local favorites, breakfast plates, lunch specials, and hearty dinner options.</span></li>
                        <li><i class="bi bi-check-circle-fill"></i> <span>Comfortable dining spaces for quick weekday meals, family gatherings, and weekend catch-ups.</span></li>
                        <li><i class="bi bi-check-circle-fill"></i> <span>Easy reservations and pre-ordering so your table is ready when you arrive.</span></li>
                    </ul>
                    <p>
                        Whether you are planning a relaxed meal for two or a group dinner with friends, our kitchen focuses on fresh ingredients, generous portions, and warm hospitality from start to finish.
                    </p>
                    <div class="position-relative mt-4">
                        <img src="<?= Html::encode(Url::to('@web/yummy-red/img/about-2.jpg')) ?>" class="img-fluid" alt="Signature dish">
                        <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="operations" class="why-us section light-background">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="why-box">
                    <h3>Why Choose Yummy Red</h3>
                    <p>
                        We make dining simple: browse the menu, reserve your table, pre-plan your meal, and enjoy restaurant favorites prepared with consistency and care.
                    </p>
                    <div class="text-center">
                        <a href="<?= Html::encode(Url::to(['/site/checkout'])) ?>" class="more-btn"><span>Go to Checkout</span> <i class="bi bi-chevron-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 d-flex align-items-stretch">
                <div class="row gy-4 w-100" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-xl-4">
                        <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-cart-check"></i>
                            <h4>Easy Pre-Order</h4>
                            <p>Pick your dishes ahead of time, review everything in one place, and arrive knowing your order is already planned.</p>
                        </div>
                    </div>
                    <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-card-list"></i>
                            <h4>Curated Menus</h4>
                            <p>Explore neatly organized starters, breakfast picks, lunch plates, and dinner favorites crafted for every appetite.</p>
                        </div>
                    </div>
                    <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-calendar-heart"></i>
                            <h4>Table Reservations</h4>
                            <p>Reserve your visit in minutes for date nights, team lunches, birthday dinners, and relaxed weekend meals.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="stats" class="stats section dark-background">
    <img src="<?= Html::encode(Url::to('@web/yummy-red/img/stats-bg.jpg')) ?>" alt="Background" data-aos="fade-in">
    <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="<?= $bookingCount ?>" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Bookings</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="<?= $availableMenuCount ?>" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Available Dishes</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="<?= count($menusByCategory) ?>" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Menu Categories</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stats-item text-center w-100 h-100">
                    <span data-purecounter-start="0" data-purecounter-end="<?= $confirmedBookingCount ?>" data-purecounter-duration="1" class="purecounter"></span>
                    <p>Confirmed Orders</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="menu" class="menu section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Our Menu</h2>
        <p><span>Check Our</span> <span class="description-title">Yummy Menu</span></p>
    </div>

    <div class="container">
        <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <?php foreach (array_keys($categoryTitles) as $index => $categoryKey): ?>
                <li class="nav-item">
                    <a class="nav-link <?= $index === 0 ? 'active show' : '' ?>" data-bs-toggle="tab" data-bs-target="#menu-<?= Html::encode($categoryKey) ?>">
                        <h4><?= Html::encode($categoryTitles[$categoryKey]) ?></h4>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="tab-content" data-aos="fade-up" data-aos-delay="200">
            <?php foreach (array_keys($categoryTitles) as $index => $categoryKey): ?>
                <?php $items = $menusByCategory[$categoryKey] ?? []; ?>
                <div class="tab-pane fade <?= $index === 0 ? 'active show' : '' ?>" id="menu-<?= Html::encode($categoryKey) ?>">
                    <div class="tab-header text-center">
                        <p>Menu</p>
                        <h3><?= Html::encode($categoryTitles[$categoryKey]) ?></h3>
                    </div>
                    <div class="row gy-5">
                        <?php if ($items): ?>
                            <?php foreach ($items as $itemIndex => $menu): ?>
                                <?php
                                $imageFile = $menu->image ?: $fallbackImages[$itemIndex % count($fallbackImages)];
                                $imageUrl = Url::to('@web/yummy-red/img/menu/' . ltrim($imageFile, '/'));
                                ?>
                                <div class="col-lg-4 menu-item">
                                    <img src="<?= Html::encode($imageUrl) ?>" class="menu-img img-fluid" alt="<?= Html::encode($menu->name) ?>">
                                    <h4><?= Html::encode($menu->name) ?></h4>
                                    <p class="ingredients"><?= Html::encode($menu->ingredients ?: 'Chef special') ?></p>
                                    <p class="price">RM <?= Html::encode(number_format((float) $menu->price, 2)) ?></p>
                                    <button
                                        class="btn-add-cart"
                                        data-id="<?= Html::encode((string) $menu->id) ?>"
                                        data-name="<?= Html::encode($menu->name) ?>"
                                        data-price="<?= Html::encode(number_format((float) $menu->price, 2, '.', '')) ?>"
                                        data-image="<?= Html::encode($imageFile) ?>"
                                        onclick="addToCart(this)"
                                    >
                                        Add to Cart
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center text-muted py-4">No menu items in this category yet.</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="book-a-table" class="book-a-table section light-background">
    <div class="container section-title" data-aos="fade-up">
        <h2>Reservation</h2>
        <p><span>Book</span> <span class="description-title">A Table</span></p>
    </div>

    <div class="container">
        <div class="row g-0" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-4 reservation-img" style="background-image: url(<?= Html::encode(Url::to('@web/yummy-red/img/reservation.jpg')) ?>);"></div>
            <div class="col-lg-8 d-flex align-items-center reservation-form-bg">
                <div class="php-email-form w-100">
                    <div class="row gy-4">
                        <div class="col-lg-6">
                            <h3>Ready to take reservations</h3>
                            <p>Reserve your table in advance or confirm your meal plan before you arrive. For private dining and larger groups, contact us at <?= Html::encode(Yii::$app->restaurantInfo->reservationSummary) ?></p>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-grid gap-3">
                                <a class="btn-get-started text-center" href="<?= Html::encode(Url::to(['/site/checkout'])) ?>">Reserve Your Table</a>
                                <a class="btn-get-started text-center" href="<?= Html::encode(Url::to(['/booking/index'])) ?>">Manage Reservations</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="gallery" class="gallery section">
    <div class="container section-title" data-aos="fade-up">
        <h2>Gallery</h2>
        <p><span>Check</span> <span class="description-title">Our Gallery</span></p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-3">
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <div class="col-lg-3 col-md-4 col-6">
                    <a href="<?= Html::encode(Url::to("@web/yummy-red/img/gallery/gallery-$i.jpg")) ?>" class="glightbox">
                        <img src="<?= Html::encode(Url::to("@web/yummy-red/img/gallery/gallery-$i.jpg")) ?>" class="img-fluid rounded-3" alt="Gallery image <?= $i ?>">
                    </a>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<section id="contact" class="contact section light-background">
    <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p><span>Need Help?</span> <span class="description-title">Contact Us</span></p>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            <div class="col-md-6">
                <div class="info-item d-flex align-items-center">
                    <i class="icon bi bi-geo-alt flex-shrink-0"></i>
                    <div>
                        <h3>Our Address</h3>
                        <p><?= Html::encode(Yii::$app->restaurantInfo->address) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item d-flex align-items-center">
                    <i class="icon bi bi-envelope flex-shrink-0"></i>
                    <div>
                        <h3>Email Us</h3>
                        <p><?= Html::encode(Yii::$app->restaurantInfo->email) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item d-flex align-items-center">
                    <i class="icon bi bi-telephone flex-shrink-0"></i>
                    <div>
                        <h3>Call Us</h3>
                        <p><?= Html::encode(Yii::$app->restaurantInfo->phone) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-item d-flex align-items-center">
                    <i class="icon bi bi-share flex-shrink-0"></i>
                    <div>
                        <h3>Open Hours</h3>
                        <p><strong><?= Html::encode(Yii::$app->restaurantInfo->openingHours) ?></strong></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="200">
            <a href="<?= Html::encode(Url::to(['/site/contact'])) ?>" class="btn-get-started">Open Contact Form</a>
        </div>
    </div>
</section>

<style>
.btn-add-cart {
    display: block;
    width: 100%;
    margin-top: 10px;
    padding: 8px 16px;
    background: #ce1212;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s;
}

.btn-add-cart:hover {
    background: #a50e0e;
}
</style>

<script>
function addToCart(button) {
    const item = {
        id: button.dataset.id,
        name: button.dataset.name,
        price: parseFloat(button.dataset.price),
        image: button.dataset.image,
        qty: 1
    };

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existing = cart.find(i => i.id === item.id);

    if (existing) {
        existing.qty += 1;
    } else {
        cart.push(item);
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    if (typeof updateCartCount === 'function') {
        updateCartCount();
    }

    button.textContent = 'Added!';
    button.style.background = '#28a745';

    setTimeout(() => {
        button.textContent = 'Add to Cart';
        button.style.background = '';
    }, 1500);
}
</script>
