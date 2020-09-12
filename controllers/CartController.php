<?php


namespace app\controllers;
use app\models\Product;
use app\models\Cart;
use Yii;

class CartController extends AppController
{
    public function actionAdd()
    {
         $id = Yii::$app->request->get('id');
         $product = Product::findOne($id);
         if (empty($product)) {
             return false;
         } else {
             $session = Yii::$app->session;
             $session->open();
             $cart = new Cart();
             $cart->addToCart($product);
             $this->layout = false;
         }
         return $this->render('cart-modal', compact('session'));
    }

    public function actionClear()
    {
        $session = Yii::$app->session;
        $session->open();
       /* $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');*/

        $session['cart'] = null; // short option
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

}