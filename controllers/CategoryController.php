<?php


namespace app\controllers;
use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;

class CategoryController extends AppController
{
    public function actionIndex()
    {
        $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
        $this->setMeta('E-Shopper'); //set meta for index page
        return $this->render('index', compact('hits'));
    }

    public function actionView($id)
    {
        //$id = Yii::$app->request->get('id');
        $infoCategory = Category::findOne($id);
        //если категория пустая
        if(empty($infoCategory)) {
            throw new \yii\web\HttpException(404, 'Категория не найдена.');
        }
        //set Meta tags
        $this->setMeta('E-Shopper | ' . $infoCategory->name, $infoCategory->keywords, $infoCategory->description);

        //pagination
        $query = Product::find()->where(['category_id' => $id]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => '3', 'pageSizeParam' => false, 'forcePageParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('view', compact('products', 'infoCategory', 'pages'));
    }

    public function actionSearch()
    {
        $searchQuery = trim(Yii::$app->request->get('searchQuery'));

            $query = Product::find()->where(['like', 'name', $searchQuery]);
            $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => '3', 'pageSizeParam' => false, 'forcePageParam' => false]);
            $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $this->setMeta('E-Shopper| Ищем'. $searchQuery);
            return $this->render('search', compact('searchQuery','products', 'pages'));
    }
}