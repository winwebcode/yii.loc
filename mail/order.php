<?php
use yii\helpers\Url;
?>
<div class="table-responsive">
    <table style="border: 1px solid #ddd; border-collapse: collapse; width: 100%;" class="table table-hover table-striped">
        <thead>
        <tr style="border: 1px solid #ddd;">
            <th style="border: 1px solid #ddd;">Наименование</th>
            <th style="border: 1px solid #ddd;">Количество</th>
            <th style="border: 1px solid #ddd;">Цена</th>
            <th style="border: 1px solid #ddd;">Сумма</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($session['cart'] as $id => $item): ?>
        <tr>
            <td style="border: 1px solid #ddd;"><a href="<?= Url::to(['product/view', 'id' => $id] , true)?>"><?= $item['name'];?></a></td>
            <td style="border: 1px solid #ddd;"><?= $item['qty'];?></td>
            <td style="border: 1px solid #ddd;"><?= $item['price'];?></td>
            <td style="border: 1px solid #ddd;"><?= $item['qty'] * $item['price'];?></td>
        </tr>
        <?php endforeach;?>
        <tr>
            <td style="border: 1px solid #ddd;" colspan="3">Итого товаров:</td>
            <td style="border: 1px solid #ddd;"><?= $session['cart.qty'];?></td>
        </tr>
        <tr>
            <td style="border: 1px solid #ddd;" colspan="3">Итоговая сумма:</td>
            <td style="border: 1px solid #ddd;"><?= $session['cart.sum'];?></td>
        </tr>
        </tbody>
    </table>
</div>
