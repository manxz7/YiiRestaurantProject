<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $model->isNewRecord ? 'Create Todo' : 'Update Todo';
?>

<div class="todo-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Masukkan tajuk task...']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 4, 'placeholder' => 'Penerangan (optional)...']) ?>

    <?= $form->field($model, 'status')->dropDownList([
        0 => '⏳ Pending',
        1 => '✅ Completed',
    ]) ?>

    <div class="form-group" style="margin-top:15px;">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ]) ?>
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>