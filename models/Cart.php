<?php


namespace app\models;

use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{
    public function addToCart($product, $qty = 1)
    {
        if(isset($_SESSION['cart'][$product->id])) {
            $_SESSION['cart'][$product->id]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$product->id] = [
                'qty' => $qty,
                'name' => $product->name,
                'price' => $product->price,
                'img' => $product->img,
            ];
        }
        if (isset($_SESSION['cart.qty'])) {
            $_SESSION['cart.qty'] = $_SESSION['cart.qty'] + $qty;
        } else {
            $_SESSION['cart.qty'] = $qty;
        }
        //total products
        if (isset($_SESSION['cart.qty'])) {
            $_SESSION['cart.sum'] = $_SESSION['cart.sum'] + $qty * $product->price;
        } else {
            $_SESSION['cart.sum'] = $qty * $product->price;
        }
    }
}