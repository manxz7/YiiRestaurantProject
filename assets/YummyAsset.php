<?php

namespace app\assets;

use yii\web\AssetBundle;

class YummyAsset extends AssetBundle
{
    public $basePath = '@webroot/yummy-red';
    public $baseUrl = '@web/yummy-red';

    public $css = [
        'vendor/bootstrap/css/bootstrap.min.css',
        'vendor/bootstrap-icons/bootstrap-icons.css',
        'vendor/aos/aos.css',
        'vendor/glightbox/css/glightbox.min.css',
        'vendor/swiper/swiper-bundle.min.css',
        'css/main.css',
    ];

    public $js = [
        'vendor/bootstrap/js/bootstrap.bundle.min.js',
        'vendor/aos/aos.js',
        'vendor/glightbox/js/glightbox.min.js',
        'vendor/purecounter/purecounter_vanilla.js',
        'vendor/swiper/swiper-bundle.min.js',
        'js/main.js',
    ];
}
