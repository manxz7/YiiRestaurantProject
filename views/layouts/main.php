<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\YummyAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;

YummyAsset::register($this);

$this->registerLinkTag(['rel' => 'preconnect', 'href' => 'https://fonts.googleapis.com']);
$this->registerLinkTag(['rel' => 'preconnect', 'href' => 'https://fonts.gstatic.com', 'crossorigin' => true]);
$this->registerCssFile('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap');

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? 'Restaurant website powered by Yii2 and the Yummy Red template.']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? 'restaurant, yii2, menu, booking']);
$this->registerLinkTag(['rel' => 'icon', 'href' => Url::to('@web/yummy-red/img/favicon.png')]);

$homeUrl = Url::to(['/site/index']);
$sectionUrl = static fn(string $section): string => $homeUrl . '#' . $section;
$isHome = Yii::$app->controller->route === 'site/index';
$bodyClass = $this->params['bodyClass'] ?? ($isHome ? 'index-page' : 'starter-page-page');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title ? $this->title . ' | ' . Yii::$app->name : Yii::$app->name) ?></title>
    <?php $this->head() ?>
</head>
<body class="<?= Html::encode($bodyClass) ?>">
<?php $this->beginBody() ?>

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="<?= Html::encode($homeUrl) ?>" class="logo d-flex align-items-center me-auto me-xl-0">
            <h1 class="sitename">Yummy Red</h1>
            <span>.</span>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="<?= Html::encode($sectionUrl('hero')) ?>" class="<?= $isHome ? 'active' : '' ?>">Home</a></li>
                <li><a href="<?= Html::encode($sectionUrl('about')) ?>">About</a></li>
                <li><a href="<?= Html::encode($sectionUrl('menu')) ?>">Menu</a></li>
                <li><a href="<?= Html::encode($sectionUrl('operations')) ?>">Operations</a></li>
                <li><a href="<?= Html::encode($sectionUrl('gallery')) ?>">Gallery</a></li>
                <li><a href="<?= Html::encode($sectionUrl('contact')) ?>">Contact</a></li>
                <li><a href="<?= Html::encode(Url::to(['/site/cart'])) ?>">Cart</a></li>
                <li><a href="<?= Html::encode(Url::to(['/menu/index'])) ?>">Manage Menu</a></li>
                <li><a href="<?= Html::encode(Url::to(['/booking/index'])) ?>">Bookings</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <?php if (Yii::$app->user->isGuest): ?>
            <a class="btn-getstarted" href="<?= Html::encode(Url::to(['/site/login'])) ?>">Login</a>
        <?php else: ?>
            <div class="d-flex align-items-center gap-2">
                <span class="small text-muted d-none d-xl-inline"><?= Html::encode(Yii::$app->user->identity->username) ?></span>
                <?= Html::beginForm(['/site/logout'], 'post') ?>
                <?= Html::submitButton('Logout', ['class' => 'btn-getstarted border-0']) ?>
                <?= Html::endForm() ?>
            </div>
        <?php endif; ?>
    </div>
</header>

<main class="main">
    <?= Alert::widget() ?>

    <?php if (!$isHome): ?>
        <section class="section light-background">
            <div class="container section-title" data-aos="fade-up">
                <h2><?= Html::encode($this->title ?: Yii::$app->name) ?></h2>
                <p><span>Explore</span> <span class="description-title"><?= Html::encode($this->title ?: Yii::$app->name) ?></span></p>
            </div>
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <?= $content ?>
            </div>
        </section>
    <?php else: ?>
        <?= $content ?>
    <?php endif; ?>
</main>

<footer id="footer" class="footer dark-background">
    <div class="container">
        <div class="row gy-3">
            <div class="col-lg-3 col-md-6 d-flex">
                <i class="bi bi-geo-alt icon"></i>
                <div>
                    <h4>Address</h4>
                    <p><?= Html::encode(Yii::$app->restaurantInfo->name) ?></p>
                    <p><?= Html::encode(Yii::$app->restaurantInfo->address) ?></p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-flex">
                <i class="bi bi-telephone icon"></i>
                <div>
                    <h4>Reservations</h4>
                    <p>
                        <strong>Phone:</strong> <span><?= Html::encode(Yii::$app->restaurantInfo->phone) ?></span><br>
                        <strong>Email:</strong> <span><?= Html::encode(Yii::$app->restaurantInfo->email) ?></span><br>
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 d-flex">
                <i class="bi bi-clock icon"></i>
                <div>
                    <h4>Opening Hours</h4>
                    <p>
                        <strong><?= Html::encode(Yii::$app->restaurantInfo->openingHours) ?></strong><br>
                        <strong>Sunday</strong>: <span>Closed</span>
                    </p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <h4>Built With Yii2</h4>
                <p>Restaurant landing page and admin flows adapted from the Yummy Red template.</p>
            </div>
        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>&copy; <span><?= date('Y') ?></span> <strong class="px-1 sitename">Yummy Red</strong> <span>All Rights Reserved</span></p>
    </div>
</footer>

<a href="<?= Html::encode(Url::to(['/site/cart'])) ?>" style="
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: #ce1212;
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: bold;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    z-index: 9999;
">
    Cart
    <span id="cart-count" style="
        position: absolute;
        top: -5px;
        right: -5px;
        background: #333;
        color: white;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    ">0</span>
</a>

<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<div id="preloader"></div>

<script>
function updateCartCount() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const total = cart.reduce((sum, item) => sum + item.qty, 0);
    const countEl = document.getElementById('cart-count');
    if (countEl) {
        countEl.textContent = total;
    }
}

document.addEventListener('DOMContentLoaded', updateCartCount);
</script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
