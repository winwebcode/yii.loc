<?php


namespace app\controllers;
use app\models\Order;
use app\models\Product;
use app\models\Cart;
use Yii;

class CartController extends AppController
{
    public function actionAdd()
    {
         $id = Yii::$app->request->get('id');
         $qty = (int) Yii::$app->request->get('qty');
         if (empty($qty)) {
             $qty = 1;
         } else {
             $qty = $qty;
         }
        //$qty = !$qty ? 1 : $qty;
         $product = Product::findOne($id);
         if (empty($product)) {
             return false;
         } else {
             $session = Yii::$app->session;
             $session->open();
             $cart = new Cart();
             $cart->addToCart($product, $qty);
             if (!Yii::$app->request->isAjax) {
                 //если не ajax , отправляем юзера обратно откуда пришёл
                 return $this->redirect(Yii::$app->request->referrer);
             }
             $this->layout = false;
         }
         return $this->render('cart-modal', compact('session'));
    }

    public function actionClear()
    {
        $session = Yii::$app->session;
        $session->open();
        $session->remove('cart');
        $session->remove('cart.qty');
        $session->remove('cart.sum');
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionDelItem()
    {
        $id = Yii::$app->request->get('id');
        $session = Yii::$app->session;
        $session->open();
        $cart = new Cart();
        $cart->recalc($id);
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionShow()
    {
        $session = Yii::$app->session;
        $session->open();
        $this->layout = false;
        return $this->render('cart-modal', compact('session'));
    }

    public function actionView()
    {
        $session = Yii::$app->session;
        $session->open();
        $this->setMeta('Корзина');
        $order = new Order();
        if ($order->load(Yii::$app->request->post())) {
            $order->qty = $session['cart.qty'];
            $order->sum = $session['cart.sum'];
            if($order->save()) {
                Yii::$app->session->setFlash('success', 'Ваш заказ принят. Вам позвонит наш менеджер');
                return  $this->refresh(); // перезагрузка в случае успеха
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка оформления заказа.');
            }
        }

        return $this->render('view', compact('session','order'));
    }
}