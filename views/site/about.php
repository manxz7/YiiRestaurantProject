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
            <h2>Restaurant-style frontend, Yii2 backend</h2>
            <p class="lead">This project combines the Yummy Red template with your Yii2 CRUD application so the public site and admin flows feel like one product.</p>
            <ul class="list-unstyled">
                <li class="mb-3"><i class="bi bi-check-circle-fill text-danger me-2"></i>Dynamic menu showcase from your database</li>
                <li class="mb-3"><i class="bi bi-check-circle-fill text-danger me-2"></i>Reservation pages wired into Yii routes</li>
                <li class="mb-3"><i class="bi bi-check-circle-fill text-danger me-2"></i>Todo, menu, and booking management kept inside the same app</li>
            </ul>
            <a href="<?= Html::encode(Url::to(['/site/index', '#' => 'menu'])) ?>" class="btn-get-started">See Featured Menu</a>
        </div>
    </div>
</div>
