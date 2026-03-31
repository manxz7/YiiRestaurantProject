<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Menu $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ingredients')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?php if (!$model->isNewRecord && !empty($model->image)): ?>
        <div class="mb-3">
            <label class="form-label">Current Image</label>
            <div>
                <img src="<?= Html::encode($model->getImageUrl()) ?>" alt="<?= Html::encode($model->name) ?>" style="max-width: 180px; border-radius: 10px;">
            </div>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'imageFile')->fileInput(['accept' => '.png,.jpg,.jpeg,.webp']) ?>

    <?= $form->field($model, 'category')->dropDownList(\app\models\Menu::categoryOptions(), ['prompt' => 'Choose a category']) ?>

    <?= $form->field($model, 'is_available')->dropDownList([
        1 => 'Available',
        0 => 'Unavailable',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
