<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'About';
?>
<div class="row gy-5 align-items-center">
    <div class="col-lg-6">
        <img src="<?= Html::encode(Url::to('@web/yummy-red/img/about.jpg')) ?>" class="img-fluid rounded-4 shadow-sm" alt="About Yummy Red">
    </div>
    <div class="col-lg-6">
        <div class="content">
            <h2>Bold flavors, warm hospitality, memorable meals</h2>
            <p class="lead">Yummy Red is inspired by the comfort of neighborhood dining and the energy of a modern city restaurant, serving familiar favorites with a vibrant signature touch.</p>
            <ul class="list-unstyled">
                <li class="mb-3"><i class="bi bi-check-circle-fill text-danger me-2"></i>Freshly prepared dishes made for casual lunches and long dinners</li>
                <li class="mb-3"><i class="bi bi-check-circle-fill text-danger me-2"></i>Signature sauces, grilled specialties, and seasonal chef highlights</li>
                <li class="mb-3"><i class="bi bi-check-circle-fill text-danger me-2"></i>Welcoming spaces for families, friends, and special occasions</li>
            </ul>
            <a href="<?= Html::encode(Url::to(['/site/index', '#' => 'menu'])) ?>" class="btn-get-started">Explore Our Menu</a>
        </div>
    </div>
</div>
