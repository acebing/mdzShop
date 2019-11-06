<?php
namespace app\admin\Controller;
use app\admin\Controller\Base;
class GoodsAttr extends Base
{
	// 商城首页
    public function list()
    {
    	
        return $this->view->fetch('mall/goods_attr_list');
    }
    // 商城登录首页
    public function add()
    {
    	
        return $this->view->fetch('mall/goods_attr_add');
    }
    // 商城登录首页
    public function valList()
    {
        
        return $this->view->fetch('mall/goods_attr-val_list');
    }
     // 商城登录首页
    public function valAdd()
    {
        
        return $this->view->fetch('mall/goods_attr-val_add');
    }
}