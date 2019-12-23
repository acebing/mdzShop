<?php
namespace app\admin\Controller\mall;
use app\admin\Controller\Base;
class Kill extends Base
{   
     // 秒杀列表
    public function list()
    {
        
        return $this->view->fetch('mall/marketing/kill_list');
    }
    // 添加秒杀活动
    public function add()
    {
        
        return $this->view->fetch('mall/marketing/kill_add');
    }
    // 添加秒杀商品 
    public function goodsAdd()
    {
        
        return $this->view->fetch('mall/marketing/kill_goods_add');
    }
     // 添加秒杀时间段
    public function timeAdd()
    {
        
        return $this->view->fetch('mall/marketing/kill_time_add');
    }
     // 秒杀时间段添加商品列表
    public function timeList()
    {
        
        return $this->view->fetch('mall/marketing/kill_time_list');
    }
      // 编辑秒杀时间
    public function time()
    {
        
        return $this->view->fetch('mall/marketing/kill_time');
    }
    
    
}