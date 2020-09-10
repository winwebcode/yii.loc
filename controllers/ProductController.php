<?php


namespace app\controllers;
use Yii;
use app\models\Category;
use app\models\Product;

class ProductController extends AppController
{
    public function actionView($id)
    {
        $hits = Product::find()->where(['hit' => '1'])->limit(3)->all();
       // $id = Yii::$app->request->get('id');
        $product = Product::findOne($id);
        if(empty($product)) {
            throw new \yii\web\HttpException(404, 'Товар не найден.');
        }
        $this->setMeta($product->name, $product->keywords, $product->description);
        return $this->render('view', compact('product', 'hits'));
    }
}