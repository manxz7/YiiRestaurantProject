<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Contact';
?>
<div class="row gy-4">
    <div class="col-lg-4">
        <div class="info-item d-flex align-items-center mb-4">
            <i class="icon bi bi-geo-alt flex-shrink-0"></i>
            <div>
                <h3>Address</h3>
                <p><?= Html::encode(Yii::$app->restaurantInfo->address) ?></p>
            </div>
        </div>
        <div class="info-item d-flex align-items-center mb-4">
            <i class="icon bi bi-envelope flex-shrink-0"></i>
            <div>
                <h3>Email</h3>
                <p><?= Html::encode(Yii::$app->restaurantInfo->email) ?></p>
            </div>
        </div>
        <div class="info-item d-flex align-items-center">
            <i class="icon bi bi-telephone flex-shrink-0"></i>
            <div>
                <h3>Phone</h3>
                <p><?= Html::encode(Yii::$app->restaurantInfo->phone) ?></p>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
            <div class="alert alert-success">Thank you for contacting us. We will get back to you soon.</div>
        <?php else: ?>
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <div class="row gy-3">
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'placeholder' => 'Your name']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Your email']) ?>
                </div>
                <div class="col-12">
                    <?= $form->field($model, 'subject')->textInput(['placeholder' => 'Subject']) ?>
                </div>
                <div class="col-12">
                    <?= $form->field($model, 'body')->textarea(['rows' => 6, 'placeholder' => 'Message']) ?>
                </div>
                <div class="col-12">
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
                        'template' => '<div class="row g-2 align-items-center"><div class="col-md-4">{image}</div><div class="col-md-8">{input}</div></div>',
                    ]) ?>
                </div>
                <div class="col-12">
                    <?= Html::submitButton('Send Message', ['class' => 'btn-get-started border-0', 'name' => 'contact-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        <?php endif; ?>
    </div>
</div>
