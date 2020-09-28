<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1>Просмотр заказа № <?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'created_at',
            'updated_at',
            'qty',
            'sum',
            //'status',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    if ($model->status === '0') {
                        return '<span class="text-danger">Активен</span>';
                    } else {
                        return '<span class="text-success">Завершён</span>';
                    }
                },
                'format' => 'html', //enable html
            ],

            'name',
            'email:email',
            'phone',
            'address',
        ],
    ]) ?>

    <?php $items = $model->orderItems; ?>

    <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Сумма</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php foreach($items as $item) :?>

                        <td><a href="<?= Url::to(['/product/view', 'id' => $item['product_id']])?>"><?= $item['name'];?></a></td>
                        <td><?= $item['qty_item'];?></td>
                        <td><?= $item['price'];?></td>
                        <td><?= $item['sum_item'];?></td>
                        </tr>
                        <?php $summa = $summa + $item['price'] * $item['qty_item'];?>
                    <?php endforeach;?>
    <tr>
        <td colspan="3">Итого:</td>
        <td><?= $summa;?></td>
    </tr>

    </tbody>
    </table>
</div>



</div>
