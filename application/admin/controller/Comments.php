<?php
namespace app\admin\Controller;
use app\admin\Controller\Base;
class Comments extends Base
{   
     // 评论列表
    public function list()
    {
        
        return $this->view->fetch('mall/goods_comments_list');
    }
    // 评论回复
    public function conten()
    {
        
        return $this->view->fetch('mall/goods_comments_conten');
    }
   
}