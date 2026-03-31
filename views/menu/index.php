<?php

use app\models\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Menu', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'ingredients:ntext',
            'price',
            [
                'attribute' => 'image',
                'format' => 'raw',
                'value' => static function (Menu $model) {
                    return !empty($model->image)
                        ? Html::img($model->getImageUrl(), ['alt' => $model->name, 'style' => 'max-width:80px; border-radius:8px;'])
                        : '(no image)';
                },
            ],
            [
                'attribute' => 'category',
                'value' => static function (Menu $model) {
                    return \app\models\Menu::categoryOptions()[$model->category] ?? $model->category;
                },
            ],
            //'is_available',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Menu $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
