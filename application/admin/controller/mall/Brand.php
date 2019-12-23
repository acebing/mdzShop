<?php
namespace app\admin\Controller\mall;
use app\admin\Controller\Base;
class Brand extends Base
{   
     // 品牌列表
    public function list()
    {
        
        return $this->view->fetch('mall/goods/goods_brand_list');
    }
     // 添加品牌
    public function add()
    {
        
        return $this->view->fetch('mall/goods/goods_brand_add');
    }
}