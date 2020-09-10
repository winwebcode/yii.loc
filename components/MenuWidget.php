<?php
namespace  app\components;

use phpDocumentor\Reflection\Types\Null_;
use yii\base\Widget;
use app\models\Category;
use Yii;

class MenuWidget extends Widget
{
    public $tpl;
    public $data; //array category
    public $tree; //array tree of category
    public $menuHtml;

    public function init()
    {
        parent::init();
        if ($this->tpl === null) {
            $this->tpl = 'menu';
        }
        $this->tpl .= '.php';
    }

    public function run()
    {
        //get cache
        $menu = Yii::$app->cache->get('menu');
        if ($menu != null) {
            return $menu;
        }
        else {
            $this->data = Category::find()->asArray()->indexBy('id')->all(); //data = список кат. с инд. по ID
            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);

            //set cache
            Yii::$app->cache->set('menu', $this->menuHtml, 30);
            return $this->menuHtml;
        }
    }

    protected function getTree()
    {
        $tree = [];
        foreach ($this->data as $id=>&$node) {
            if (!$node['parent_id']) {
                $tree[$id] = &$node;
            }
            else {
                  $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
            }
        }
        return $tree;
    }

    protected function getMenuHtml($tree)
    {
        $str = '' ;
        foreach ($tree as $category) {
            $str .= $this->catToTemplate($category);
        }
        return $str;
    }

    protected function catToTemplate($category)
    {
        ob_start();
        include  __DIR__ .'/menu_tpl/' . $this->tpl;
        return ob_get_clean();
    }

}