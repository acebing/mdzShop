<?php
namespace app\admin\Controller;
use \think\Config;
use app\admin\Controller\Base;
class Order extends Base
{
	// 商城首页
    public function add()
    {
    	
        return $this->view->fetch('mall/order_add');
    }
    // 商城登录首页
    public function add1()
    {
    	
        return $this->view->fetch('mall/order_add1');
    }
    public function add2()
    {
        
        return $this->view->fetch('mall/order_add2');
    }
    public function add3()
    {
        
        return $this->view->fetch('mall/order_add3');
    }
    public function add4()
    {
        
        return $this->view->fetch('mall/order_add4');
    }
    public function add5()
    {
        
        return $this->view->fetch('mall/order_add5');
    }
    public function add6()
    {
        
        return $this->view->fetch('mall/order_add6');
    }
    public function add7()
    {
        
        return $this->view->fetch('mall/order_add7');
    }
    // 商城登录首页
    public function list()
    {
        
        return $this->view->fetch('mall/order_list');
    }
     // 商城登录首页
    public function info()
    {
        
        return $this->view->fetch('mall/order_info');
    }
      // 退货订单
    public function reason()
    {
        
        return $this->view->fetch('mall/return_reason_1');
    }
      // 退货原因订单列表
    public function reasonList()
    {
        
        return $this->view->fetch('mall/return_reason_list');
    }
    // 添加退货原因
    public function reasonAdd()
    {
        
        return $this->view->fetch('mall/return_reason_add');
    }
    // 添加退货原因
    public function sales()
    {
        
        return $this->view->fetch('mall/sales_list');
    }
    // 添加退货原因
    public function shipments()
    {
        
        return $this->view->fetch('mall/shipments_list');
    }
}