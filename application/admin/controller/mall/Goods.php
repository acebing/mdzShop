<?php
namespace app\admin\Controller\mall;
use app\admin\Controller\Base;
class Goods extends Base
{   
     // 商品列表
    public function list()
    {
        
        return $this->view->fetch('mall/goods/goods_list');
    }
    // 添加商品
    public function add()
    {
        
        return $this->view->fetch('mall/goods/goods_add');
    }
   
}