<?php

use app\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Товары';
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()
            ? Html::a('Создать товар', ['create'], ['class' => 'btn btn-success'])
            : ''
        ?>
    </p>

    <?php
    Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'category_id',
            [
                'attribute' => 'photo',
                'format' => 'html',
                'value' => fn($value) => Html::img("../$value->photo", [
                        'size' => '250px'
                ])
            ],
            'name',
            'price',
            //'country',
            //'year',
            //'model',
            //'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php
    Pjax::end(); ?>

</div>